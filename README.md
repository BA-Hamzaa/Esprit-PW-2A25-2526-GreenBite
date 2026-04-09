# 🌱 GreenBite - PHP MVC Nutrition & Marketplace Application

GreenBite is a comprehensive web application built with PHP MVC architecture, designed to promote healthy eating through nutrition tracking, recipe management, and a marketplace for organic products.

## ✨ Features

- **User Authentication**: Secure login and registration system
- **Nutrition Tracking**: Monitor daily meals and nutritional intake
- **Recipe Management**: Browse, create, and manage recipes with ingredients
- **Marketplace**: Buy and sell organic products
- **Community Forum**: Share experiences and tips
- **Admin Dashboard**: User management and statistics
- **Responsive Design**: Mobile-friendly interface

## 🛠 Technologies Used

- **Backend**: PHP 7.4+ with MVC architecture
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Styling**: Custom CSS with CSS Variables
- **Icons**: Inline SVG icons
- **Fonts**: Google Fonts (Inter & Poppins)

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL database
- Web server (Apache/Nginx) or PHP built-in server

### Database Setup
1. Create a MySQL database named `nutrigreen`
2. Import the `database.sql` file located in the project root
3. Update database credentials in `config/database.php` if necessary

### Running the Application

#### Option 1: Using the provided batch file (Windows)
Double-click `start.bat` to start the development server on `http://localhost:8000`

#### Option 2: Command Line
```bash
php -S localhost:8000 -t public
```
Access the application at `http://localhost:8000`

#### Option 3: Apache Server
Place the project in your web server's document root and access via your server URL.

## 📁 Project Structure

```
PHP Greenbite/
├── app/
│   ├── controllers/          # MVC Controllers
│   │   ├── MarketplaceController.php
│   │   ├── NutritionController.php
│   │   └── RecettesController.php
│   ├── models/               # Data Models
│   │   ├── Aliment.php
│   │   ├── Commande.php
│   │   ├── Ingredient.php
│   │   ├── Produit.php
│   │   ├── Recette.php
│   │   └── Repas.php
│   └── views/                # PHP View Templates
│       ├── home.php
│       ├── layouts/
│       │   ├── front_header.php
│       │   └── front_footer.php
│       └── marketplace/
│           ├── front_list.php
│           └── front_detail.php
├── config/
│   └── database.php          # Database configuration
├── public/
│   ├── index.php             # Front controller
│   └── assets/
│       ├── css/
│       │   ├── style.css
│       │   ├── variables.css
│       │   └── fonts.css
│       └── js/
│           └── main.js
├── database.sql              # Database schema
├── start.bat                 # Windows startup script
└── README.md
```

## 🎨 Design System

### Color Palette
- **Primary**: `#2D6A4F` (Dark Green)
- **Secondary**: `#52B788` (Light Green)
- **Muted**: `#F4F1DE` (Beige)
- **Accent**: `#E76F51` (Orange)
- **Success**: `#40C057` (Green)
- **Text**: `#2D2D2D` (Charcoal)

### Typography
- **Headings**: Poppins (600-700 weight)
- **Body Text**: Inter (300-600 weight)

### Key Components
- Buttons (`.btn`, `.btn-primary`, `.btn-secondary`)
- Cards (`.card`)
- Forms (`.form-input`, `.form-input-icon`)
- Navigation (`.sidebar`, `.admin-sidebar`)
- Progress bars and badges

## 📊 Database Schema

The application uses MySQL with the following main tables:
- `users` - User accounts
- `aliments` - Food items with nutritional data
- `recettes` - Recipes
- `ingredients` - Recipe ingredients
- `produits` - Marketplace products
- `commandes` - Orders
- `repas` - Meals

## 🔧 Usage

1. **Registration/Login**: Create an account or log in
2. **Dashboard**: View your nutrition overview
3. **Nutrition**: Track meals and monitor intake
4. **Recipes**: Browse and create recipes
5. **Marketplace**: Shop for organic products
6. **Community**: Engage with other users
7. **Admin Panel**: Manage users and view statistics (admin access required)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 📞 Contact

For questions or support, please open an issue on GitHub.

---

**Note**: This application is designed to promote healthy eating and sustainable consumption through technology.