const { Theme, ThemeManager } = require('tailwindcss-theming/api');
const { TinyColor } = require('@ctrl/tinycolor');

const nordPalette = {
  // Polar night
  nord0: '#2E3440',
  nord1: '#3B4252',
  nord2: '#434c5e',
  nord3: '#4C566A',

  // Snow storm
  nord4: '#D8DEE9',
  nord5: '#E5E9F0',
  nord6: '#ECEFF4',

  // Frost
  nord7: '#8FBCBB',
  nord8: '#88C0D0',
  nord9: '#81A1C1',
  nord10: '#5E81AC',

  // Aurora
  nord11: '#BF616A',
  nord12: '#D08770',
  nord13: '#EBCB8B',
  nord14: '#A3BE8C',
  nord15: '#B48EAD',

  // Other
  white: 'white',
};

const arcLight = new Theme()
  .setName('arc-light')
  .addColors({
    'toolbar': '#313742',
    'on-toolbar': '#d3dae3',
    'sidebar': '#404552',
    'on-sidebar': '#d3dae3',
    'background': '#ffffff',
    'on-background': '#5c616c',
    'error': 'rgb(215, 58, 73)',
    'on-error': new TinyColor('rgb(215, 58, 73)').darken(40),
    'warning': 'rgb(219, 171, 9)',
    'on-warning': new TinyColor('rgb(219, 171, 9)').darken(40),
    'success': 'rgb(40, 167, 69)',
    'on-success': new TinyColor('rgb(40, 167, 69)').darken(40),
    'uncommon': 'rgb(117, 128, 142)',
    'on-uncommon': new TinyColor('rgb(117, 128, 142)').darken(40),
  })
  // .addColorVariant('subtle', nordPalette.nord3, ['on-background'])
  // .addColorVariant('muted', new TinyColor(nordPalette.nord3).lighten(), ['on-background'])
  // .addColorVariant('active', nordPalette.nord1, ['on-background'])
  // .addColorVariant('hover', nordPalette.nord2, ['on-background'])
  // .addColorVariant('focus', nordPalette.nord3, ['on-background'])

const arcDark = new Theme()
  .setName('arc-dark')
  .addColors({
    'toolbar': '#313742',
    'on-toolbar': '#d3dae3',
    'sidebar': '#404552',
    'on-sidebar': '#d3dae3',
    'background': '#373d48',
    'on-background': '#d3dae3',
    'error': 'rgb(215, 58, 73)',
    'on-error': new TinyColor('rgb(215, 58, 73)').darken(40),
    'warning': 'rgb(219, 171, 9)',
    'on-warning': new TinyColor('rgb(219, 171, 9)').darken(40),
    'success': 'rgb(40, 167, 69)',
    'on-success': new TinyColor('rgb(40, 167, 69)').darken(40),
    'uncommon': 'rgb(117, 128, 142)',
    'on-uncommon': new TinyColor('rgb(117, 128, 142)').darken(40),
  })
  // .addColorVariant('subtle', nordPalette.nord3, ['on-background'])
  // .addColorVariant('muted', new TinyColor(nordPalette.nord3).lighten(), ['on-background'])
  // .addColorVariant('active', nordPalette.nord1, ['on-background'])
  // .addColorVariant('hover', nordPalette.nord2, ['on-background'])
  // .addColorVariant('focus', nordPalette.nord3, ['on-background'])

const nordLight = new Theme()
  .setName('nord-light')
  .addColors({
    'toolbar': nordPalette.nord5,
    'on-toolbar': nordPalette.nord1,
    'sidebar': nordPalette.nord4,
    'on-sidebar': nordPalette.nord0,
    'background': nordPalette.nord6,
    'on-background': nordPalette.nord2,
    'error': nordPalette.nord11,
    'on-error': new TinyColor(nordPalette.nord11).darken(40),
    'warning': nordPalette.nord13,
    'on-warning': new TinyColor(nordPalette.nord13).darken(40),
    'success': nordPalette.nord14,
    'on-success': new TinyColor(nordPalette.nord14).darken(40),
    'uncommon': nordPalette.nord15,
    'on-uncommon': nordPalette.nord0,
  })
  // .addColorVariant('subtle', nordPalette.nord3, ['on-background'])
  // .addColorVariant('muted', new TinyColor(nordPalette.nord3).lighten(), ['on-background'])
  // .addColorVariant('active', nordPalette.nord1, ['on-background'])
  // .addColorVariant('hover', nordPalette.nord2, ['on-background'])
  // .addColorVariant('focus', nordPalette.nord3, ['on-background'])

const nordDark = new Theme()
  .setName('nord-dark')
  .addColors({
    'toolbar': nordPalette.nord1,
    'on-toolbar': nordPalette.nord6,
    'sidebar': nordPalette.nord2,
    'on-sidebar': nordPalette.nord6,
    'background': nordPalette.nord0,
    'on-background': nordPalette.nord6,
    'error': nordPalette.nord11,
    'on-error': new TinyColor(nordPalette.nord11).darken(40),
    'warning': nordPalette.nord13,
    'on-warning': new TinyColor(nordPalette.nord13).darken(40),
    'success': nordPalette.nord14,
    'on-success': new TinyColor(nordPalette.nord14).darken(40),
    'uncommon': nordPalette.nord15,
    'on-uncommon': nordPalette.nord0,
  })
  // .addColorVariant('subtle', new TinyColor(nordPalette.nord5), ['on-background'])
  // .addColorVariant('muted', new TinyColor(nordPalette.nord4).darken(), ['on-background'])
  // .addColorVariant('active', nordPalette.nord5, ['on-background'])
  // .addColorVariant('hover', nordPalette.nord4, ['on-background'])
  // .addColorVariant('focus', new TinyColor(nordPalette.nord4).darken(), ['on-background'])

module.exports = new ThemeManager()
  .setDefaultTheme(arcLight.targetable())
  .setDefaultLightTheme(arcLight.targetable())
  .setDefaultDarkTheme(arcDark.targetable())
  .addTheme(nordLight.targetable())
  .addTheme(nordDark.targetable());
