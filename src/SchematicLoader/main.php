<?PHP
namespace SchematicLoader;
//必須
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
//Command
use pocketmine\command\{
	Command, CommandExecutor, CommandSender
};
//SchematicLoader
use SchematicLoader\command\{BuildCommand};
use SchematicLoader\utils\JEtoBE;

use pocketmine\Player;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info("Schematic Loader was enabled.");
        if(!file_exists("./plugins/schematics")){
            mkdir("./plugins/schematics");
            mkdir("./plugins/schematics/resources/");
        }
        if(!file_exists("./plugins/schematics/resources/PEtoJE.json")){
            mkdir("./plugins/schematics/resources/");
            file_put_contents("./plugins/schematics/resources/PEtoJE.json",json_encode(JEtoBE::$list,JSON_PRETTY_PRINT));
        }
        
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args):bool{
        switch (strtolower($command->getName())) {
            case "build":
                if($sender instanceof Player){
                    if(!isset($args[0]) or !isset($args[1]) or !isset($args[2]) or !isset($args[3])){
                        $sender->sendMessage("コマンドの引数が不足しています。");
                        return false;
                    }else if(!is_numeric($args[1]) or !is_numeric($args[2]) or !is_numeric($args[3])){
                        $sender->sendMessage("コマンドの第一,第二,第三引数は数字である必要があります。");
                        return false;
                    }else if(!file_exists('./plugins/schematics/'.$args[0])){
                        $sender->sendMessage("指定したファイルは存在しません。");
                        return false;
                    }
                    $buildcommand=new BuildCommand($args[0],$args[1],$args[2],$args[3],$sender);
                    $buildcommand->excute();
                    return true;
                }else{
                    $sender->sendMessage("コンソールからは実行できません。");
                    return true;
                }
            break;
        }   
        return false;
    }
}
?>