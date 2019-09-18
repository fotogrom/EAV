<?php


namespace App\Gromov\EAVBundle\Controller;

use FactoryBundle\Entity\FieldNames;
use FactoryBundle\Entity\FieldValues;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FieldNamesController extends Controller
{
    private function createEntity($availableEntity)
    {

        $ae = explode("/", $availableEntity);
        $ap = array_pop($ae);
        $newentity = "Extra" . $ap;


        $webRoot = explode("/", $_SERVER['DOCUMENT_ROOT']);
        $le = array_pop($webRoot);
        $src = implode("/", $webRoot) . "/src/" . implode("/", $ae) . "/" . $newentity . ".php";


        $newrepository = $newentity . "Repository";
        $as = $ae;

        $ap2 = array_pop($as);
        $srcR = implode("/", $webRoot) . "/src/" . implode("/", $as) . "/Repository";

        $repClass = implode("\\", $as) . "\Repository\\" . $newrepository;
        $repNamespace = implode("\\", $as) . "\\Repository";


        if (!file_exists($src)) {
            $fp = fopen($src, "wb");
            fwrite($fp, "<?php \r\n namespace " . implode("\\", $ae) . ";\r\n\r\n");
            fwrite($fp, "use Doctrine\ORM\Mapping as ORM;\r\n\r\n");


            $annotation = <<<EOT
/**
*@ORM\Entity(repositoryClass="$repClass")
*@ORM\Table(name="field_values")
*/
EOT;

            fwrite($fp, $annotation . "\r\n");
            fwrite($fp, "class " . $newentity . " {\r\n");

            $_id = <<<EOT
/**
* @ORM\Id
* @ORM\Column(type="integer")
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected \$id;
              
            
public function getId(){
       return \$this->id;
              }
              
static \$entity = "$availableEntity";               
              
              
              
EOT;

            fwrite($fp, $_id . "\r\n");


            fwrite($fp, "\r\n}");


            fclose($fp);
        }


        if (!is_dir($srcR)) mkdir($srcR);

        $fRep = $srcR . "/" . $newrepository . ".php";
        if (!file_exists($fRep)) {

            $fp = fopen($fRep, "wb");

            fwrite($fp, "<?php \r\n namespace $repNamespace;\r\n\r\n");
            fwrite($fp, "use " . implode("\\", $ae) . "\\" . $newentity . ";\r\n");
            fwrite($fp, "use Doctrine\ORM\EntityRepository;\r\n\r\n");


            fwrite($fp, "class " . $newrepository . " extends EntityRepository {\r\n");

            $functions = <<<EOT
 public function getFields(\$id = null){

        return \$this->getEntityManager()->createQuery(
          "SELECT n.name,v.val,v.entityData,n.id FROM FactoryBundle:FieldNames n LEFT JOIN FactoryBundle:FieldValues v  WITH v.fieldName = n.id WHERE n.entity='".$newentity::\$entity."' AND n.enabled='1'".((\$id!=null)?" AND v.entityData=\$id":"")

        )
            ->getResult();


    }


    public function getFieldNames(\$id=null){
        if(\$id==null)
            return \$this->getEntityManager()->createQuery(
            "SELECT n.name,n.description,n.type,n.defaultValue, '' as val FROM FactoryBundle:FieldNames n WHERE n.entity='".$newentity::\$entity."'  AND n.enabled='1'"

        )
            ->getResult();
        else {
            return \$this->getEntityManager()->createQuery(


                "SELECT n.name,n.description,n.id,n.type,n.defaultValue,(SELECT v.val FROM FactoryBundle:FieldValues v  WHERE v.entityData=\$id AND v.fieldName = n.id) as val FROM FactoryBundle:FieldNames n WHERE n.entity='".$newentity::\$entity."'  AND n.enabled='1'"
            )
                ->getResult();

        }

    }

    public function getFieldIds(){

        return \$this->getEntityManager()->createQuery(
            "SELECT n.name,n.id FROM FactoryBundle:FieldNames n WHERE n.entity='".$newentity::\$entity."'  AND n.enabled='1'"

        )
            ->getResult();

    }


    public function getDistinctFields(){

        return \$this->getEntityManager()->createQuery(
            "SELECT n.name,n.description,n.id FROM FactoryBundle:FieldNames n WHERE n.entity='".$newentity::\$entity."'  AND n.enabled='1'"

        )
            ->getResult();


    }




    public function insertFieldValues(\$insertArray,\$id)
    {
        \$arrayNames = \$this->getFieldIds();

        \$datetime = new \DateTime();
        \$date = \$datetime->format('Y-m-d h:i:s');


        foreach (\$arrayNames as \$key => \$value) {

            \$insertArray[\$value['name']] = (trim(\$insertArray[\$value['name']])=="")?\$this->getDefaultValue(\$value['id']):\$insertArray[\$value['name']];

            \$sql = "INSERT INTO field_values(field_name_id,entity_data_id,val,created_at,enabled) VALUES('" . \$value['id'] . "','\$id','" . \$insertArray[\$value['name']] . "','\$date','1')";

            \$stmt = \$this->getEntityManager()->getConnection()->prepare(\$sql);

            \$stmt->execute();


        }
    }


    public function updateFieldValues(\$updateArray, \$id){
            \$arrayNames = \$this->getFieldIds();



            foreach(\$arrayNames as \$key=>\$value){

                \$updateArray[\$value['name']] = (trim(\$updateArray[\$value['name']])=="")?\$this->getDefaultValue(\$value['id']):\$updateArray[\$value['name']];


             

                if( !\$this->checkField(\$value['id'],\$id)){

                    \$datetime = new \DateTime();

                    \$date = \$datetime->format('Y-m-d h:i:s');

                    \$sql = "INSERT INTO field_values(field_name_id,entity_data_id,val,created_at,enabled) VALUES('" . \$value['id'] . "','\$id','" . \$updateArray[\$value['name']] . "','\$date','1')";

                    \$stmt = \$this->getEntityManager()->getConnection()->prepare(\$sql);

                    \$stmt->execute();


                }
                else
                \$this->getEntityManager()->createQueryBuilder()
                            ->update('FactoryBundle:FieldValues','f')
                            ->set('f.val',':val')
                            ->where('f.fieldName = :fName AND f.entityData=:id')
                            ->setParameter('val',\$updateArray[\$value['name']])
                            ->setParameter('fName',\$value['id'])
                            ->setParameter('id',\$id)
                            ->getQuery()
                            ->execute();


            }








    }



    private function checkField(\$fieldName,\$id){

       \$result = \$this->getEntityManager()->createQuery(
           // "SELECT v.val FROM FactoryBundle:FieldValues v WHERE v.entityData=\$id AND v.fieldName = \$fieldName"
           "SELECT COUNT(v) as val from FactoryBundle:FieldValues v WHERE v.entityData=\$id AND v.fieldName = \$fieldName"

        )
            ->getOneOrNullResult();



        if(\$result['val']=='1') return true;
        
        //if(\$result['val']|| \$result['val']==\$this->getDefaultValue(\$fieldName)) return true;
        else return false;

    }

    private function getDefaultValue(\$fieldName){
    
     \$result = \$this->getEntityManager()->createQuery(
            "SELECT n.defaultValue FROM FactoryBundle:FieldNames n WHERE n.id = \$fieldName"

        )
            ->getOneOrNullResult();
    
    return \$result['defaultValue'];
    
    }


EOT;


            fwrite($fp, $functions);


            fwrite($fp, "\r\n}");
        }


    }
}