| label (en) | label (de) | explanation | check | strict check |
|---|---|---|---|---|
| Super Admin | Super Administrator | master of multisite | ```current_user_can('manage_network')``` |```current_user_can('manage_network')``` |
| Administrator | Administrator | master of single site | ```current_user_can('manage_options')``` |```current_user_can('manage_options')&&!current_user_can('manage_network')``` |
| Editor | Redakteur | publish / manage posts AND pages (also of others) | ```current_user_can('edit_others_posts')``` |```current_user_can('edit_others_posts')&&!current_user_can('manage_options')``` |
| Author | Autor | publish / manage posts (only own) | ```current_user_can('publish_posts')``` |```current_user_can('publish_posts')&&!current_user_can('edit_others_posts')``` |
| Contributor | Mitarbeiter | manage posts (only own) | ```current_user_can('edit_posts')``` |```current_user_can('edit_posts')&&!current_user_can('publish_posts')``` |
| Subscriber | Abonnent | manage profile | ```current_user_can('read')``` |```current_user_can('read')&&!current_user_can('edit_posts')``` |