const colors = require("tailwindcss/colors");

module.exports = {
    darkMode: "media",
    purge: {
        // enabled: true,
        content: [
            "app/**/*.php",
            "resources/**/*.html",
            "resources/**/*.js",
            "resources/**/*.jsx",
            "resources/**/*.ts",
            "resources/**/*.tsx",
            "resources/**/*.php",
            "resources/**/*.vue",
            "resources/**/*.twig"
        ],
        options: {
            // defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
            whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/]
        }
    },
    theme: {
        fontSize: {
            xs: ["10px", "14px"],
            sm: ["12px", "16px"],
            base: ["14px", "20px"],
            lg: ["16px", "24px"],
            xl: ["20px", "28px"]
        },
        extend: {
            screens: {
                xl: "1140px"
            },
            colors: {
                brand: {
                    "50": "#fbf7f2",
                    "100": "#fcefe4",
                    "200": "#f9dbc4",
                    "300": "#f7bc91",
                    "400": "#f78f51",
                    "500": "#f7652a",
                    "600": "#ed421b",
                    "700": "#cd321e",
                    "800": "#a42820",
                    "900": "#83211e"
                },
                gray: {
                    50: "#F9FAFB",
                    100: "#F3F4F6",
                    200: "#E5E7EB",
                    300: "#D1D5DB",
                    400: "#9CA3AF",
                    500: "#6B7280",
                    600: "#2F3640",
                    700: "#1B1E22",
                    800: "#15181B",
                    900: "#0C1014"
                }
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
    variants: {},
    plugins: []
};
