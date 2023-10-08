# Doubacore
 A bunch of essential tools for a PocketMine server

## Permissions

| Command           | Permission                          | Description                          |
|-------------------|-------------------------------------|--------------------------------------|
| `/god`            | `doubacore.command.god`             | Grant god mode.                      |
| `/god`            | `doubacore.command.god.self`        | Grant god mode to self.              |
| `/god <player>`   | `doubacore.command.god.other`       | Grant god mode to others.            |
| `/heal`           | `doubacore.command.heal`            | Heal yourself.                       |
| `/heal`           | `doubacore.command.heal.self`       | Heal yourself.                       |
| `/heal <player>`  | `doubacore.command.heal.other`      | Heal others.                         |
| `/warp`           | `doubacore.command.warp`            | Use warp command.                    |
| `/warp <name>`    | `doubacore.command.warp.*`          | Grant access to all available warps. |
| `/warp <name>`    | `doubacore.command.warp.[warpName]` | Grant access to a specific warp.     |
| `/warp`           | `doubacore.command.warp.list`       | List available warps.                |
| `/setwarp <name>` | `doubacore.command.setwarp`         | Set a warp point.                    |
| `/delwarp <name>` | `doubacore.command.delwarp`         | Delete a warp point.                 |
