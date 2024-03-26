```shell script

php artisan crud:make Customer --schema="id:number, expo_push_token:string, locale:string, created_at:date, updated_at:date" --filterable="id, expo_push_token, locale, created_at, updated_at" --sortable="id, created_at, updated_at" --searchable="expo_push_token, locale" -m

php artisan crud:make Sticker --schema="id:number, sticker_id:number, description:string, colors:string, color:string, shape:string, family_id:number, family_name:string, team_name:string, added:number, pack_id:number, pack_name:string, pack_items:number, tags:string, equivalents:number, images:json, created_at:date, updated_at:date" --filterable="id, sticker_id, description, pack_name, family_name, team_name, pack_name, created_at, updated_at" --sortable="id, sticker_id, description, pack_name, family_name, team_name, pack_name, tags, created_at, updated_at" --searchable="description, tags" -m

```
