# Hello Theme Child

Hello Theme Child is a child theme for [Hello Elementor](https://wordpress.org/themes/hello-elementor/). It extends the parent theme with a modular asset pipeline, a component system, debugging helpers, a development live reload, and a set of sensible global CSS/JS defaults for Elementor sites.

## Features

### Asset management

- **Child stylesheet**: `style.css` is enqueued after the parent theme's `hello-elementor-theme-style`, versioned with the theme version declared in its header.
- **Declarative CSS/JS registration**: styles and scripts are listed in arrays in [includes/setup/enqueue-assets.php](includes/setup/enqueue-assets.php). Each entry defines a handle, path, dependencies and (for scripts) whether to load in the footer. Handles are automatically prefixed with `htc-`.
- **External libraries**: a dedicated `$externals` array in the same file lets you load third-party scripts from a CDN, with the same handle/URL/dependency/footer options.
- **Automatic cache busting**: when `WP_DEBUG` is on, every asset is versioned with the current timestamp so changes are never served from cache.
- **Numbered file convention**: files are named with a numeric prefix (`00-main`, `10-homepage`) to keep load order explicit and predictable.

### Component system

Components are self-contained units with their own PHP, CSS and JS, stored in `components/<name>/`.

- Registered in one place: the `htc_register_components()` function in [includes/setup/components-loader.php](includes/setup/components-loader.php).
- For each registered component the loader automatically:
  - `require_once`s `components/<name>/<name>.php` on `after_setup_theme`;
  - enqueues `components/<name>/<name>.css` and `<name>.js` **only if they exist**, versioned with the file's modification time.
- Per-component options: `css_deps`, `js_deps` and `in_footer` (default `true`).
- A missing component PHP file does not break the site; it is written to the theme log instead.

### Development tools

- **CSS live reload** ([includes/setup/dev-tools.php](includes/setup/dev-tools.php)): scans the theme recursively for `.css` files, polls them every 500 ms and hot-swaps any stylesheet that changed, with no page reload.
- Enabled **only when `WP_DEBUG` is `true`**, so it never runs in production.

### Helpers

Defined in [helpers/](helpers/) and loaded by [includes/setup/include-php.php](includes/setup/include-php.php):

| Function | Description |
| --- | --- |
| `htc_print_r($var)` | Prints a variable wrapped in `<pre>` for quick on-page debugging. |
| `htc_log($data, $label = '')` | Appends a timestamped, optionally labelled entry to `htc.log` in the theme folder. Arrays and objects are serialized with `print_r`. The log file is git-ignored. |
| `htc_add_svg_support` | Filter on `upload_mimes` that allows uploading SVG files to the media library. |

> **Note:** SVG uploads are not sanitized. Only allow trusted users to upload them, or add a sanitizer plugin.

### Page-specific includes

[includes/pages/](includes/pages/) is intended for per-page PHP logic. `10-homepage.php` and `assets/css/10-homepage.css` are ready, empty placeholders for homepage-specific code and styles. Add new files to the `$roots_includes` array in `include-php.php`.

### Global CSS defaults

Provided by [assets/css/00-main.css](assets/css/00-main.css):

- **Fluid `rem` scaling**: above 767px the root font size is `1.04166667vw` (1rem = 20px on a 1920px viewport); on mobile it is fixed at `20px`. Sizes expressed in `rem` scale with the viewport.
- **Hidden page title**: `h1.entry-title` is hidden, as pages are usually laid out with Elementor.
- **Homepage horizontal overflow** is prevented on `body.home`.
- **Elementor Text Editor widget**: removes the bottom margin from the last paragraph.
- **Cleaner interactions**: disables the tap highlight on mobile and the focus outline.
- A commented template to document the site's global color variables (`--e-global-color-*`).

### Global JS

Provided by [assets/js/00-main.js](assets/js/00-main.js):

- **Automatic current year**: any element with the class `current-year-footer` is filled with the current year, useful for footer copyright text.
- A commented snippet to remove the `#` from the URL after clicking a "scroll down" button (`.htc-scroll-down-button`).

### Safety and licensing

- Every PHP file exits when accessed directly (`ABSPATH` check).
- Distributed under GPL v3 or later.

## Requirements

- WordPress
- Parent theme: Hello Elementor

## Installation

1. Copy the child theme folder into `wp-content/themes/`.
2. Make sure the parent theme, Hello Elementor, is installed.
3. Activate **Hello Theme Child** from the WordPress admin panel.

## Project structure

```
hello-theme-child/
├── assets/
│   ├── css/            # Global styles (00-main.css, 10-homepage.css)
│   └── js/             # Global scripts (00-main.js)
├── components/         # Reusable components (create it when you add the first one)
│   └── <name>/
│       ├── <name>.php
│       ├── <name>.css
│       └── <name>.js
├── helpers/            # debug.php, utility.php
├── includes/
│   ├── pages/          # Page-specific PHP (10-homepage.php)
│   └── setup/          # enqueue-assets, include-php, components-loader, dev-tools
├── functions.php       # Main entry point
├── style.css           # Theme header + child stylesheet
└── screenshot.png
```

## Usage

### Add a global style or script

1. Create the file in `assets/css/` or `assets/js/`, e.g. `20-blog.css`.
2. Register it in the `$styles` or `$scripts` array in `includes/setup/enqueue-assets.php`:

```php
[
    'handle' => '20-blog',
    'path'   => '/assets/css/20-blog.css',
    'deps'   => [],
],
```

### Load an external library

Add an entry to `$externals` in `includes/setup/enqueue-assets.php`:

```php
[
    'handle'    => 'my-library',
    'url'       => 'https://cdn.jsdelivr.net/npm/my-library@1.0.0/dist/my-library.js',
    'deps'      => [],
    'in_footer' => false,
],
```

### Create a component

1. Create `components/my-component/` with `my-component.php` and, optionally, `my-component.css` and `my-component.js`.
2. Register it in `htc_register_components()` in `includes/setup/components-loader.php`:

```php
return [
    'my-component' => [
        'css_deps'  => [],
        'js_deps'   => [],
        'in_footer' => true,
    ],
];
```

### Add a PHP include

Create the file (in `helpers/` or `includes/pages/`) and add its path to `$roots_includes` in `includes/setup/include-php.php`.

### Debugging

```php
htc_print_r($some_array);            // dump on the page
htc_log($some_array, 'my-label');    // append to wp-content/themes/hello-theme-child/htc.log
```

## Development

Set `WP_DEBUG` to `true` in `wp-config.php` to enable CSS live reload and timestamp-based cache busting. Set it back to `false` in production. To disable only the live reload, remove the `require_once` of `dev-tools.php` in `functions.php`.

## License

This project is distributed under the GNU General Public License v3 or later.
