# [Best & Flanagan]

- [Site URL]
- [Description of Project]

- Third Party APIs:
- Licenses:

## Host

- Pantheon: [DEV](https://dev-kmag.pantheonsite.io/)
- Pantheon: [TEST](https://test-kmag.pantheonsite.io/)
- [Additional details]

## Features

- Relies on **Composer** and **GNU Make** and is the recommended way to use this stack
- Makefile directives for build automation
- Dependency management with [Composer](http://getcomposer.org)
- Easy WordPress configuration with environment specific files
- Environment variables with [Dotenv](https://github.com/vlucas/phpdotenv)
- Autoloader for mu-plugins (use regular plugins as mu-plugins)
- Enhanced security (separated web root and secure passwords with [wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt))

## Requirements

- Requires a minimum of WordPress 6.1
- PHP >= 8.0
- NVM
- [Node.js](https://github.com/ModernClimate/mc-wp-starter-theme/wiki/Install-Node.js)
- [Yarn](https://yarnpkg.com/en/docs/install)
- [Composer](https://getcomposer.org/doc/00-intro.md#globally) >= 2

## Environmental Checks

The `.env` will be generated during the initial `Make Create` build. The `.env` file type has been added to the .gitignore and should never be committed to the repo.

## Local Installation

1. Clone this repository into a new project directory.
2. Create MAMP host and database for your new project, with the Document root pointing to the root of your new project.
3. Run `make create` and follow prompts to generate the `.env` file:
   - `DB_NAME` - Database name
   - `DB_USER` - Database user
   - `DB_PASSWORD` - Database password
   - `DB_HOST` - Database host
   - `WP_HOME` - Full URL to WordPress home (https://mc-wp-starter.local)
   - `ACF_PRO_KEY` - License key in MC 1Pass vault.
   - `WPM_PRO_KEY` - License key in MC 1Pass vault.
4. Run `make project` to define the project theme name and remote repository.
   - `ENV_THEME` - Theme directory name
   - `REMOTE_REPO` - Remote repository URL (leave blank if no repository exists)
5. Run `make build` to install package dependencies in the theme and build our assets.
6. Access WordPress admin at https://mc-wp-starter.local/wp/wp-admin/
7. Save Permalinks to generate .htaccess file

## Building with make

Project build automation is handled with `make`. The `makefile` defined in the project root contains our set of rules to define the builds.

Available commands are listed below:

- `make help` Displays a list of all available commands, as well as a short description of their intended use.
- `make clean` Clears composers internal package cache.
- `make create` Will install all composer dependencies and rename starter theme to defined project name. Prompts for user input for generation of environment variables.
- `make deploy` Packages current state of the codebase and deploys to remote repo in `/wp` directory.
- `make dev` Renames `/wp/wp-config.php` file to be ignored by WordPress and fallback to our root config. This is to be used for local development.
- `make install` Installs composer dependencies.
- `make package` Builds working copies of themes and plugins within the `/wp` directory.
- `make prod` Rename `/wp/wp-config.php` file to be recognized by WordPress core installation in `/wp` directory.
- `make remote` Clones remote repository to /wp directory.
- `make update` Updates your composer dependencies to the latest version according to composer.json.

## Resources

1. [PSR-4 Autoloader](http://www.php-fig.org/psr/psr-4/)
2. [PSR-2 PHP Coding Style Guide](http://www.php-fig.org/psr/psr-2/)

## Copyright and License

All other resources and theme elements are licensed under the [GNU GPL](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html), version 2 or later.
