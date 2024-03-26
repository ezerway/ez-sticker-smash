```shell script

yarn crud:make customers --name="Customer | Customers" --icon="mdi-account-group" --api="customers" --fields="id:number, expo_push_token, locale, created_at:date, updated_at:date" --columns="id, expo_push_token, locale, created_at, updated_at" --filterable="id, expo_push_token, locale, created_at, updated_at" --sortable="id, created_at, updated_at" --lint

yarn crud:make stickers --name="Sticker | Stickers" --icon="mdi-emoticon" --api="stickers" --fields="id:number, sticker_id:number, description, pack_name, family_name, team_name, pack_name, created_at:date, updated_at:date" --columns="id, sticker_id, description, tags, pack_name, created_at, updated_at" --filterable="id, sticker_id, description, tags, pack_name, created_at, updated_at" --sortable="id, sticker_id, pack_name, created_at, updated_at" --lint


```
