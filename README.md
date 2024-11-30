# Laravel Project Setup

1. Install **Herd** if you haven't already. You can download it from https://herd.laravel.com/windows.
   
2. Open Herd and select **Add Existing Project**.
   
3. Choose the folder where this Laravel project is located.

4. Open the terminal inside Herd and run the following commands:

   - Run `composer install` to install the project dependencies.
   
   - Copy the `.env.example` file to `.env` by running: `cp .env.example .env`.

   - Run migration and seed.
   
   - 'php artisan migrate' and 'php artisan db::seed'

   - Seeder will populate the database with dummy hobbies, Goals, and etc that is required

   - One Admin will be created 'admin@example.com' with password 'password'

   - For front end (Admin panel) will have to run  'npm run dev '

5. After that open URL `https://dating_app.test/`

NOTE: 

Postman Collection: I have included the Postman collections for both Mobile APIs and Web APIs. These collections provide the API endpoints for the respective platforms.

Frontend Admin Panel: The frontend admin panel is incomplete, but it is aligned with the provided Figma design. You should be able to get a clear idea of the layout and functionality from the available portion.

Social Login Issue: There was an issue with the redirect for the social login (Facebook and Google). I didn’t spend time debugging this issue, so I have left it out. However, once the issue with the redirect is resolved, the social login functionality should work as expected.

Mail Service: For email functionality, I have used Mailtrap for testing purposes. You will need to replace it with your own email service for production use.


PHP vesion : 8.2
Laravel : 11.9
Database : Mysql


Enjoy coding!
