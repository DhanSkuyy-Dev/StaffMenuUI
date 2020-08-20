<?php

namespace DhanSkuyy\Staff;

use pocketmine\Server;

use pocketmine\Player;

use pocketmine\plugin\Plugin;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\utils\TextFormat as C;

use pocketmine\math\Vector3;

use pocketmine\level\Position;

use pocketmine\level\Level;

use pocketmine\entity\{Effect, EffectInstance, Entity};

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\command\CommandExecutor;

use pocketmine\command\ConsoleCommandSender;

use jojoe77777\FormAPI;

use jojoe77777\FormAPI\SimpleForm;

use jojoe77777\FormAPI\CustomForm;

use jojoe77777\FormAPI\ModalForm;

class StaffMenu extends PluginBase implements Listener {

	    public function onEnable() {

        $this->getServer()->getPluginManager()->registerEvents($this, $this);    

        $this->getLogger()->info(C::GREEN . "Plugin Has Been Enabled By DhanSkuyy");

    }

    public function onDisable() {

        $this->getLogger()->info(C::RED . "Plugin Has Been Disable By DhanSkuyy");

    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {

        switch($cmd->getName()){                    

            case "staffmenu":

                if ($sender->hasPermission("staffmenu.cmd")){

                     $this->StaffMenu($sender);

                }else{     

                     $sender->sendMessage(C::RED . "§cYour No Have Permissions To Use This Command!");

                     return true;

                }     

            break;         

            

         }  

        return true;                         

    }

   

    public function StaffMenu($sender){ 

        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

        $form = $api->createSimpleForm(function (Player $sender, int $data = null){

            $result = $data;

            if($result === null){

			return true;

            }             

            switch($result){

                case 0:

                    $this->GamemodeUI($sender);

                break;   

                case 1:

                    $this->VanishUI($sender);

                break;   

                case 2:

                    $this->Nick($sender);

                break;   

                case 3:

                    $this->getServer()->getCommandMap()->dispatch($sender, "staffchat");

                break;   

                case 4:

                    $this->Teleport($sender);

                 break;   

                case 5:

                    $this->Kick($sender);

                break;   

                case 6:

                    $this->Ban($sender);

                break;

                case 7:

                break;

            }

        });

        $form->setTitle("§a§lStaffMenu");

        $form->setContent("§eSelect A StaffMenu Category");

        $form->addButton("§bGAMEMODE\n§7§oTap To Change Gamemode",0,"textures/items/totem");

        $form->addButton("§eVANISH\n§7§oTap To Vanish Menu",0,"textures/ui/invisibility_effect");

        $form->addButton("§dCHANGE NICK\n§7§oTap To Change Nick", 0, "textures/ui/editIcon");

        $form->addButton("§9STAFF CHAT\n§7§oTap To StaffChat Menu",0,"textures/ui/Feedback");

        $form->addButton("§aTELEPORT\n§7§oTap To Telepor To Player",0,"textures/ui/magnifyingGlass");

        $form->addButton("§6KICK PLAYER\n§7§oTap To Kick Player",0,"textures/ui/Caution");

        $form->addButton("§cBAN MENU\n§7§oTap To Ban Menu",0,"textures/ui/ErrorGlyph");

        $form->addButton("§4CLOSE\n§fTap To Close",0,"textures/blocks/barrier");

        $form->sendToPlayer($sender);

        return true;

    }

    

    public function GamemodeUI($sender){ 

        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {

            $result = $data;

            if($result === null){

                return true;

            }             

            switch($result){

                case 0:

                 $sender->setGamemode(0);

                 $sender->sendMessage("§aSucces! §fYour Gamemode Has Been Changed To §cSurvival");

                 $sender->addTitle("§cSurvival", "§fYour Gamemode Is Survival");

                break;

                case 1:

                 $sender->setGamemode(1);

                 $sender->sendMessage("§aSucces! §fYour Gamemode Has Been Changed To §aCreative");

                 $sender->addTitle("§aCreative", "§fYour Gamemode Is Creative");

                break;

                case 2:

                 $sender->setGamemode(2);

                 $sender->sendMessage("§aSucces! §fYour Gamemode Has Been Changed To §bAdventure");

                 $sender->addTitle("§bAdventure", "§fYour Gamemode Is Adventure");

                break;

                case 3:

                 $sender->setGamemode(3);

                 $sender->sendMessage("§aSucces! §fYour Gamemode Has Been Changed To §eSpecator");

                 $sender->addTitle("§eSpectator", "§fYour Gamemode Is Spectator");

                break;

                case 4:

                 $command = "staffmenu" ;

                 $this->getServer()->getCommandMap()->dispatch($sender, $command);

                }

            });

            $form->setTitle("§e§lGAMEMODE MENU");

            $form->addButton("§cSurvival\n§7§oTap To Change Gamemode", 0, "textures/items/totem");

            $form->addButton("§aCreative\n§7§oTap To Change Gamemode", 0, "textures/items/totem");

            $form->addButton("§bAdventure\n§7§oTap To Change Gamemode", 0, "textures/items/totem");

            $form->addButton("§eSpectator\n§7§oTap To Change Gamemode", 0, "textures/items/totem");

            $form->addButton("§l§cBACK\n§0§oTap To Back",0,"textures/blocks/barrier");

            $form->sendToPlayer($sender);

            return true;

    }

    

    public function VanishUI($sender){

      	$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {

            $result = $data;

            if($result === null){

                return true;

            }             

            switch($result){

                    case 0:

			         $sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);

		             $sender->setNameTagVisible(false);

			         $sender->addTitle("§aVanish", "§fHas Been Enable");

                    break;

                    case 1:

                     $sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);

			         $sender->setNameTagVisible(true);

			         $sender->addTitle("§cVanish", "§fHas Been Disable");

                    break;

                    case 2:

                     $this->getServer()->getCommandMap()->dispatch($player, "staffmenu");

                    break;

                    	

            }

        });

        $form->setTitle("§b§lVanish");

        $form->addButton("§eVANISH §aON\n§7§oTap To Enable",0,"textures/ui/check");

        $form->addButton("§eVANISH §cOFF\n§7§oGap To Disable",0,"textures/ui/cancel");

        $form->addButton("§eBACK\n§7§oTap To Back",0,"textures/blocks/barrier");

        $form->sendToPlayer($sender);

        return true;

    }

    

    public function Nick($player){

    $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

    $form = $api->createSimpleForm(function (Player $player, int $data = null){

      $result = $data;

      if($result === null){

        return true;

      }

      switch($result){

          case 0:

          

            $this->ChangeNick($player);

          

          break;

          

          case 1:

          

            $this->ResetNick($player);

          

          break;

          

          case 2:

          

          break;

         

      }

    });

    $form->setTitle("§a§lCHANGE NICK");

    $form->addButton("§eChange Nick\n§7§oTap To Change Nick", 0, "textures/items/name_tag");

    $form->addButton("§cReset Nick\n§7§oTap To Reset Your Nick", 0, "textures/ui/refresh_light");

    $form->addButton("§l§cBACK\n§7§oTap To Back",0,"textures/blocks/barrier");

    $form->sendToPlayer($player);

    return true;

  }

  

  public function ChangeNick($player){

    $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

    $form = $api->createCustomForm(function (Player $player, array $data = null){

      if($data === null){

        return true;

      }

      if($data[0] == "reset"){

        $this->ResetNick($player); 

      }

      $player->setDisplayName($data[0]);

      $player->setNameTag($data[0]);

      $player->sendMessage("§aYour nickname was changed to §f" . $data[0]);

    });

    $form->setTitle("§l§aCHANGE NICK");

    

    $form->addInput("Enter your New Name!", "New Nick..");

    

    $form->sendToPlayer($player);

    

    }

  

    private function ResetNick(Player $player){

  	 $player->setDisplayName($player->getName());

  	 $player->setNameTag($player->getName());

     $player->sendMessage("§aSucces! §fYour NickName Has Been Changed");

 

    }

    public function Teleport($sender){

      	$form = new CustomForm(function (Player $sender, $data){

            if($data !== null){

				

			    $this->getServer()->getCommandMap()->dispatch($sender, "tp $data[0]");

		

				}

		});

		$form->setTitle("§l§aTELEPORT");

        $form->addInput("Player Name");

        

		$form->sendToPlayer($sender);

		

		}

		

        public function Kick($sender){

      	$form = new CustomForm(function (Player $sender, $data){

            if($data !== null){

				

			    $this->getServer()->getCommandMap()->dispatch($sender, "kick $data[0]");

		

				}

		});

		$form->setTitle("§l§cKICK PLAYER");

		

        $form->addInput("Player Name");

        

		$form->sendToPlayer($sender);

		return true;

	}

        

    public function Ban($sender){

        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

        $form = $api->createSimpleForm(function (Player $sender, int $data = null){

            $result = $data;

            if($result === null){

                return true;

            }             

            switch($result){

                    case 0:

                       $this->Banned($sender);

                    break;

                    case 1:

                       $this->Unbanned($sender);

                    break;

                    case 2:

                       $this->getServer()->getCommandMap()->dispatch($sender, "staffmenu");

                    break;

            }

        });

        $form->setTitle("§c§lBAN MENU");

        $form->setContent("");

        $form->addButton("§cBAN PLAYER\n§7§oTap To Ban Player",0,"textures/ui/store_play_button");

        $form->addButton("§eUNBAN PLAYER\n§7§oTap To Unban Player",0,"textures/ui/store_play_button");

        $form->addButton("§l§cBACK\n§7§oTap To Back",0,"textures/blocks/barrier");

        $form->sendToPlayer($sender);

        return true;

    } 

    

    public function Banned($sender){

     

       $form = new CustomForm(function (Player $sender, $data){

            if($data !== null){

				

			    $this->getServer()->getCommandMap()->dispatch($sender, "ban $data[0]");

		

				}

		});

		$form->setTitle("§l§cBAN PLAYER");

        $form->addInput("Player Name");

        

		$form->sendToPlayer($sender);

		

		} 

		

		public function Unbanned($sender){

		   

		   $form = new CustomForm(function (Player $sender, $data){

            if($data !== null){

				

			    $this->getServer()->getCommandMap()->dispatch($sender, "unban $data[0]");

		

				}

		});

		$form->setTitle("§l§eUNBAN PLAYER");

        $form->addInput("Player Name");

        

		$form->sendToPlayer($sender);

		return true;

		

		

	}

}
