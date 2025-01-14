import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        require("@tailwindcss/typography"),
        require("@tailwindcss/aspect-ratio"),
        require("daisyui"),
    ],

    daisyui: {
        themes: ["light"], // Disables all themes, including dark mode [1, 2, 4]
    },
};
