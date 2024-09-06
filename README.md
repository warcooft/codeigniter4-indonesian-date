# Aselsan\IndonesianDate
Lightweight Indonesian Standard Datetime Output for CodeIgniter 4

![CodeIgniter](https://img.shields.io/badge/CodeIgniter-%5E4.4.8-blue)
![PHP Version Require](https://img.shields.io/badge/PHP-%5E8.0-blue)

# Quick Start
1. Install with Composer
```
composer require aselsan/indonesian-date
```
2. Set up your entity
```php
use Aselsan\IndonesianDate\Traits\IndonesianDateTraits;
use CodeIgniter\Shield\Entities\User as ShieldUserEntity;

class User extends ShieldUserEntity
{
    use IndonesianDateTraits;

    public function __construct(?array $data = null)
    {
        parent::__construct($data);
    }

```

# Usage
```php
 /**
   * Default parameters for indonesianDate
   * indonesianDate(string $attribute, bool $showDayOfWeek = true, bool $showTime = false)
   */

  echo auth()->user()->indonesianDate('created_at');
  // Result: "Jum'at, 6 September 2024"

  // If you want to hide the day of the week, set the second parameter to false
  echo auth()->user()->indonesianDate('created_at', false);
  // Result: "6 September 2024"

  // If you want to display the time, set the third parameter to true
  echo auth()->user()->indonesianDate('created_at', false, true);
  // Result: "6 September 2024 18:00"

  // Get zodiac sign
  echo auth()->user()->zodiac('tanggal_lahir');
  // Result: "Aquarius"

  // Get age
  echo auth()->user()->age('tanggal_lahir');
  // Result: 18

```

## License

This project is licensed under the MIT License - see the [LICENSE](/LICENSE) file for details.

