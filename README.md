# Hello Theme Child

Hello Theme Child is a child theme for Hello Elementor, designed to extend the parent theme with custom styles, reusable components, modularly managed assets, and a simple structure for adding frontend features.

## Main features

- Centralized management of CSS and JS through the includes/setup folder
- Support for modular components in the components folder
- Automatic CSS file reload during development
- A structure ready for future extensions and fast customization

## Requirements

- WordPress
- Parent theme: Hello Elementor

## Installation

1. Copy the child theme folder into your WordPress themes directory:
   `wp-content/themes/`
2. Activate the theme from the WordPress admin panel.
3. Customize the files in the assets folder and the components according to your needs.

## Project structure

- assets/ : global CSS and JS files
- components/ : reusable components with dedicated CSS/JS/PHP files
- helpers/ : support functions
- includes/ : setup logic, pages, and PHP includes
- functions.php : main entry point of the child theme
- style.css : main stylesheet of the theme

## Customization

### Global styles

Add or edit CSS files in the assets/css/ folder.

### Global scripts

Add or edit JS files in the assets/js/ folder.

### Components

To add a new component, create a new folder inside components/ with these files:

- component-name.php
- component-name.css
- component-name.js

Then register it in includes/setup/components-loader.php.

## Development

The theme includes a live reload mechanism for CSS files, useful during development. If you do not want to use it, you can disable it directly in the dedicated function inside functions.php.

## License

This project is distributed under the GNU General Public License v3 or later.
