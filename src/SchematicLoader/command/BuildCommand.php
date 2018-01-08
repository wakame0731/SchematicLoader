<?PHP
namespace SchematicLoader\command;

use SchematicLoader\utils\SchematicLib;
use pocketmine\math\Vector3;
use pocketmine\block\Block;

class BuildCommand{

    private $filename,$x,$y,$z,$sender;

    public function __construct($name,$x,$y,$z,$sender){
        $this->filename=$name;
        $this->x=$x;
        $this->y=$y;
        $this->z=$z;
        $this->sender=$sender;
    }

    public function excute(){
        $x=$this->x;
        $y=$this->y;
        $z=$this->z;
        $schematic=new SchematicLib($this->filename);
        $data=$schematic->getBlockData();
        foreach ($schematic->getBlocks() as $count =>$value) {
            $id=hexdec(bin2hex($value));
            $data=hexdec(bin2hex($data[$count]));
            if($this->getMaterials()=="Alpha"){
                
            }
            $this->sender->getLevel()->setBlock(new Vector3($x,$y,$z),Block::get($id,$data));
            $x++;
            if($this->x+$schematic->getWidth()==$x){
                $z++;
                $x=$this->x;
            } 
            if($this->z+$schematic->getLength()==$z){
                $y++;
                $x=$this->x;
                $z=$this->z;
            } 
        }
        $this->sender->sendMessage("実行したよ!");
    }
}

?>