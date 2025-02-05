# PUGC Events - Laravel API server for PUGC Events Mobile App

> This project is a part of the Enterprise Application Development course at PUGC. The project is developed by the students of the BS Computer Science program at PUGC. The project is developed using the Laravel framework for the API server and the React-Native framework for the mobile app.

<br/>
<div align="center">
  <h3 align="center">PUGC Events - Laravel API</h3>

  <p align="center">
    A Laravel API server for the PUGC Events Mobile App
    <br/>
    <br/>
    <a href="https://github.com/itxsaaad/pugc-events-server-laravel"><strong>Explore the docs »</strong></a>
    <br/>
    <br/>
    <a href="https://github.com/itxsaaad/pugc-events-server-laravel/issues">Report Bug</a>
    .
    <a href="https://github.com/itxsaaad/pugc-events-server-laravel/issues">Request Feature</a>
  </p>
</div>

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]

## Table Of Contents

-   [PUGC Events - Laravel API server for PUGC Events Mobile App](#pugc-events---laravel-api-server-for-pugc-events-mobile-app)
    -   [Table Of Contents](#table-of-contents)
    -   [About The Project](#about-the-project)
    -   [Features](#features)
        -   [User Authentication](#user-authentication)
        -   [Events](#events)
        -   [RSVP](#rsvp)
    -   [Built With](#built-with)
    -   [Getting Started](#getting-started)
        -   [Prerequisites](#prerequisites)
        -   [Installation](#installation)
    -   [Roadmap](#roadmap)
    -   [Contributing](#contributing)
    -   [Authors](#authors)
    -   [License](#license)
    -   [Support](#support)

## About The Project

PUGC Events is a Laravel API server for the PUGC Events Mobile App. The API server is built using the Laravel framework and provides endpoints for the mobile app to interact with the database. The API server is responsible for handling user authentication, event creation, event registration, event management, and other features of the mobile app.

## Features

### User Authentication

-   **User Registration**: User can register using their name, email and password.
-   **User Login**: User can login using their email and password.
-   **User Logout**: User can logout from the app.
-   **User Profile**: User can view their profile information.

### Events

-   **Event Creation**: Admin can create an event with the following details:

    -   Event Title
    -   Event Description
    -   Event Date
    -   Event Time
    -   Event Location

-   **Event Update**: Admin can update the event details.
-   **Event Deletion**: Admin can delete the event.
-   **Event Details**: User can view the event details.
-   **Event List**: User can view the list of all events.

### RSVP

-   **Event Registration**: User can register for an event.
-   **Event Unregistration**: User can unregister from an event.

## Built With

-   [Laravel](https://laravel.com/) - The PHP Framework For Web Artisans
-   [MySQL](https://www.mysql.com/) - The world's most popular open-source database

## Getting Started

### Prerequisites

-   [PHP](https://www.php.net/) - PHP is a popular general-purpose scripting language that is especially suited to web development.
-   [Composer](https://getcomposer.org/) - Composer is a dependency manager for PHP.
-   [Node.js](https://nodejs.org/) - Node.js is a JavaScript runtime built on Chrome's V8 JavaScript engine.
-   [NPM](https://www.npmjs.com/) - npm is the package manager for JavaScript.
-   [MySQL](https://www.mysql.com/) - The world's most popular open-source database.
-   [Git](https://git-scm.com/) - Git is a free and open-source distributed version control system.

### Installation

1. Clone the repo

    ```sh
    git clone https://github.com/itxSaaad/pugc-events-server-laravel.git
    ```

2. Install NPM packages

    ```sh
    npm install
    ```

3. Install Composer packages

    ```sh
    composer install
    ```

4. Create a new database in MySQL
5. Copy the `.env.example` file to `.env` and update the database credentials

    ```sh
    cp .env.example .env
    ```

6. Generate a new application key

    ```sh
    php artisan key:generate
    ```

7. Run the database migrations

    ```sh
    php artisan migrate
    ```

8. Start the Laravel server

    ```sh
    php artisan serve
    ```

9. The Laravel server will start at `http://localhost:8000`
10. You can now access the API server at `http://localhost:8000/api`
11. For Hot Reload, you can run the following command

    ```sh
    npm run dev
    ```

## Roadmap

See the [open issues](https://github.com/itxsaaad/pugc-events-server-laravel) for a list of proposed features (and known issues).

## Contributing

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

-   If you have suggestions for adding or removing projects, feel free to [open an issue](https://github.com/itxsaaad/pugc-events-server-laravel/issues/new) to discuss it, or directly create a pull request after you edit the _README.md_ file with necessary changes.
-   Please make sure you check your spelling and grammar.
-   Create individual PR for each suggestion.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement". Don't forget to give the project a star! Thanks again!

1. Fork the repo
2. Clone the project
3. Create your feature branch (`git checkout -b feature/AmazingFeature`)
4. Commit your changes (`git commit -m "Add some AmazingFeature"`)
5. Push to the branch (`git push origin feature/AmazingFeature`)
6. Open a pull request

## Authors

-   **Muhammad Saad** - [itxsaaad](https://github.com/itxsaaad)
-   **Mirza Moiz** - [mirza-moiz](https://github.com/mirza-moiz)
-   **Hassnain Raza** - [hassnain512](https://github.com/hassnain512)

See also the list of [contributors](https://github.com/itxsaaad/pugc-events-server-laravel/graphs/contributors)

## License

Distributed under the MIT License. See `LICENSE` for more information.

## Support

Give ⭐️ if you like this project!

<a href="https://www.buymeacoffee.com/itxSaaad"><img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" width="200" /></a>

<!-- MARKDOWN LINKS & IMAGES -->

[contributors-shield]: https://img.shields.io/github/contributors/itxsaaad/pugc-events-server-laravel.svg?style=for-the-badge
[contributors-url]: https://github.com/itxsaaad/pugc-events-server-laravel/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/itxsaaad/pugc-events-server-laravel.svg?style=for-the-badge
[forks-url]: https://github.com/itxsaaad/pugc-events-server-laravel/network/members
[stars-shield]: https://img.shields.io/github/stars/itxsaaad/pugc-events-server-laravel.svg?style=for-the-badge
[stars-url]: https://github.com/itxsaaad/pugc-events-server-laravel/stargazers
[issues-shield]: https://img.shields.io/github/issues/itxsaaad/pugc-events-server-laravel.svg?style=for-the-badge
[issues-url]: https://github.com/itxsaaad/pugc-events-server-laravel/issues
[license-shield]: https://img.shields.io/github/license/itxsaaad/pugc-events-server-laravel.svg?style=for-the-badge
[license-url]: https://github.com/itxsaaad/pugc-events-server-laravel/blob/main/LICENSE.md
