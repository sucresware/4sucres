const colors = require('tailwindcss/colors');

module.exports = {
  purge: {
    content: ['app/**/*.php', 'resources/**/*.js', 'resources/**/*.php', 'resources/**/*.vue'],
    options: {},
  },
  theme: {
    extend: {
      typography: {
        DEFAULT: {
          css: [
            {
              color: 'rgba(var(--color-on-background))',
              fontSize: 'var(--text-base)',
              fontWeight: 'var(--text-weight-normal)',
              a: {
                color: 'rgba(var(--color-variant-on-background-link))',
                fontWeight: 'var(--font-weight-semibold)',
                textDecoration: 'none',
                '&:hover': {
                  textDecoration: 'underline',
                },
              },
              strong: {
                color: 'rgba(var(--color-on-background))',
                fontWeight: 'var(--font-weight-semibold)',
              },
              hr: {
                borderColor: 'rgba(var(--color-variant-on-background-border))',
                borderTopWidth: '3px',
              },
              blockquote: {
                borderLeftColor: 'rgba(var(--color-variant-on-background-border))',
                borderLeftWidth: '3px',
                fontWeight: 'auto',
                fontStyle: 'auto',
                color: 'rgba(var(--color-on-background))',
              },
              'blockquote p:first-of-type::before': { content: '' },
              'blockquote p:last-of-type::after': { content: '' },
              'ol > li::before': {
                color: 'rgba(var(--color-variant-on-background-muted))',
              },
              'ul > li::before': {
                backgroundColor: 'rgba(var(--color-variant-on-background-muted))',
              },
              pre: {
                color: 'var(--color-on-toolbar)',
                backgroundColor: 'var(--color-toolbar)',
              },
              thead: {
                fontWeight: 'var(--font-weight-bold)',
                borderBottomColor: 'rgba(var(--color-variant-on-background-border))',
              },
              'tbody tr': {
                borderBottomWidth: '1px',
                borderBottomColor: 'rgba(var(--color-variant-on-background-border))',
              },
              h1: { color: 'rgba(var(--color-on-background))' },
              h2: { color: 'rgba(var(--color-on-background))' },
              h3: { color: 'rgba(var(--color-on-background))' },
              h4: { color: 'rgba(var(--color-on-background))' },
            },
          ],
        },
      },
      colors: {
        transparent: 'transparent',
      },
      spacing: {
        'full-plus-14': '-100% + 3.5rem',
        'full-plus-4': '-100% + 1rem',
        'full-minus-4': '-100% - 1rem',
      },
    },
    container: {
      center: true,
      padding: '1rem',
    },
  },
  variants: {
    extend: {
      opacity: ['disabled'],
      cursor: ['disabled'],
      ringColor: ['hover'],
    },
  },
  plugins: [
    require('tailwindcss-theming'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('tailwind-scrollbar'),
  ],
};
