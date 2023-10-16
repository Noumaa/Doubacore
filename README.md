# Doubacore
 A bunch of essential tools for a PocketMine server

## Permissions

| Command    | Permission                          | Description                             |
|------------|-------------------------------------|-----------------------------------------|
| `/god`     | `doubacore.command.god`             | Grant god mode.                         |
|            | `doubacore.command.god.self`        | Grant god mode to self.                 |
|            | `doubacore.command.god.other`       | Grant god mode to others.               |
| `/heal`    | `doubacore.command.heal`            | Heal yourself.                          |
|            | `doubacore.command.heal.self`       | Heal yourself.                          |
|            | `doubacore.command.heal.other`      | Heal others.                            |
| `/speed`   | `doubacore.command.speed`           | Change your speed.                      |
|            | `doubacore.command.speed.self`      | Change your speed.                      |
|            | `doubacore.command.speed.other`     | Change other's speed.                   |
| `/setwarp` | `doubacore.command.setwarp`         | Set a warp point.                       |
| `/delwarp` | `doubacore.command.delwarp`         | Delete a warp point.                    |
| `/warp`    | `doubacore.command.warp`            | Use warp command.                       |
|            | `doubacore.command.warp.*`          | Grant access to all available warps.    |
|            | `doubacore.command.warp.[warpName]` | Grant access to a specific warp.        |
|            | `doubacore.command.warp.list`       | List available warps.                   |
| `/kit`     | `doubacore.command.kit`             | Use kit command.                        |
|            | `doubacore.command.kit.*`           | Grant access to all available kits.     |
|            | `doubacore.command.kit.[kitName]`   | Grant access to a specific kit.         |
|            | `doubacore.command.kit.list`        | List available kits.                    |
| `/sethome` | `doubacore.command.sethome`         | Set a home teleportation point.         |
| `/delhome` | `doubacore.command.delhome`         | Delete a home teleportation point.      |
| `/home`    | `doubacore.command.home`            | Use home command.                       |
|            | `doubacore.command.home.[maxHomes]` | Override `max-home` config value. (WIP) |
|            | `doubacore.command.home.other`      | List and use others homes. (WIP)        |
