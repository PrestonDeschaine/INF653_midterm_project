<? php

declare(strict_types=1);

echo '<pres>';
print_r(get_env('SITE_URL'));
echo '<br>';
print_r($_SERVER);
echo '</pre>';

phpinfo();