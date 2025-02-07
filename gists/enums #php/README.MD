- Verfügbar ab PHP 8.1
- Definition einer festen Menge von möglichen Werten für einen bestimmten Typ
- Verbessert Code-Lesbarkeit

```php
enum UserRole: string
{
    case Admin = 'admin';
    case Benutzer = 'user';
    case Gast = 'guest';

    public function is_admin(): bool
    {
        if( $this === self::Admin ) { return true; }
        else { return false; }
    }
}

// usage
$role = UserRole::Benutzer;
echo $role->value; // "user"
echo '<br/>';
echo $role->is_admin() ? 'yes' : 'no'; // "no"

// loop
echo '<br/>';
foreach (UserRole::cases() as $cases__value) {
    echo $cases__value->name; // "Administrator", "Benutzer", "Gast"
    echo '<br/>';
}
```