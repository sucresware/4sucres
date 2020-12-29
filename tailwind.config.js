const colors = require("tailwindcss/colors");

module.exports = {
    purge: {
        content: [
            "app/**/*.php",
            "resources/**/*.js",
            "resources/**/*.php",
            "resources/**/*.vue",
        ],
        options: {
            safelist: ["dark"],
        }
    },
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                'transparent': 'transparent'
            },
            spacing: {
                "full-plus-14": "-100% + 3.5rem",
                "full-plus-4": "-100% + 1rem",
                "full-minus-4": "-100% - 1rem",
            }
        },
        container: {
            center: true,
            padding: "1rem"
        }
    },
    variants: {
        extend: {
            ringColor: ['hover'],
        }
    },
    plugins: [
        require('tailwindcss-theming')
    ]
};
