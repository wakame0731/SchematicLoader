<?PHP
namespace SchematicLoader\utils;

use pocketmine\nbt\BigEndianNBTStream;

class SchematicLib{

    private $schematic;

    public function __construct($name){
        $file = file_get_contents("./plugins/schematics/".$name);
        $data = new BigEndianNBTStream();//PMMPじゃないと動かんよ…
        $data->readCompressed($file);
        $this->schematic = $data->getData();
    }

    public function getMaterials(){
        return $this->schematic->getString("Materials");//Pocket->BE,Alpha->JE
    }

    public function getWidth(){
        return $this->schematic->getShort("Width");//X
    }

    public function getHeight(){
        return $this->schematic->getShort("Height");//Y
    }

    public function getLength(){
        return $this->schematic->getShort("Length");//Z
    }

    public function getBlocks(){
        return str_split($this->schematic->getByteArray("Blocks"));
    }

    public function getBlockData(){
        return str_split($this->schematic->getByteArray("Data"));
    }
    
}
?>