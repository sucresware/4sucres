const colors = require("tailwindcss/colors");

module.exports = {
  purge: {
    content: [
      "app/**/*.php",
      "resources/**/*.js",
      "resources/**/*.php",
      "resources/**/*.vue",
    ],
    options: {}
  },
  theme: {
    extend: {
      typography: {
        DEFAULT: {
          css: [
            {
              color: 'var(--color-on-background)',
              fontSize: 'var(--text-base)',
              fontWeight: 'var(--text-weight-normal)',
              a: {
                color: 'var(--color-variant-on-background-link)',
                fontWeight: 'var(--font-weight-semibold)',
                textDecoration: 'none',
                '&:hover': {
                  textDecoration: 'underline',
                },
              },
              strong: {
                color: 'var(--color-on-background)',
                fontWeight: 'var(--font-weight-semibold)',
              },
              hr: {
                borderColor: 'var(--color-variant-on-background-border)',
                borderTopWidth: 1,
              },
              blockquote: {
                borderLeftColor: 'var(--color-variant-on-background-border)',
              },
              pre: {
                color: 'var(--color-on-toolbar)',
                backgroundColor: 'var(--color-toolbar)',
              },
              thead: {
                fontWeight: 'var(--font-weight-bold)',
                borderBottomColor: 'var(--color-variant-on-background-border)',
              },
              'tbody tr': {
                borderBottomWidth: '1px',
                borderBottomColor: 'var(--color-variant-on-background-border)',
              },
            },
          ],
        },
      },
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
    require('tailwindcss-theming'),
    require('@tailwindcss/typography'),
    require('tailwind-scrollbar'),
  ]
};
