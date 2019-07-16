# ReportingTool

PHP Laravel Based Pentesting Report Writing Tool

## Installing

1. Copy the `.env.example` file to `.env` and change the database details in there
2. Run `php composer.phar install` and `php artisan db:migrate && php artisan db:seed`

## Usage

### To Note!

1. Currently the code looks for a file in "storage/app/uploads/Report_Template_v2.docx" as the template.

2. This will be configurable (obviously).

### Login

1. Log into the application either by registering (should work!) or by using the following credentials (found in `database/seeds/UsersTableSeeder.php`):
``` 
admin@reporter.xyz : password
```

## Issues and Contributing

Currently this is very much in the development phase and therefore contains multiple known bugs. If you notice any bugs please feel free to log an issue in GitHub Issues and I'll get around to them.

If you want to fix any bugs or add features please feel free to clone the repo, add your fixes and issue a pull-request.
