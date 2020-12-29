const { Theme, ThemeManager } = require('tailwindcss-theming/api');
const { TinyColor } = require('@ctrl/tinycolor');

const arcDark = new Theme()
  .setName('arc-dark')
  .addColors(
{
    "accent": "rgb(84, 128, 226)",
    "sidebar": "#313742",
    "on-sidebar": "#d3dae3",
    "toolbar": "#303641",
    "on-toolbar": "#d3dae3",
    "background": "#373d48",
    "on-background": "#d3dae3",
    "error": "rgb(215, 58, 73)",
    "on-error": "new TinyColor(rgb(215, 58, 73)).darken(40)",
    "warning": "rgb(219, 171, 9)",
    "on-warning": "new TinyColor(rgb(219, 171, 9)).darken(40)",
    "success": "rgb(40, 167, 69)",
    "on-success": "new TinyColor(rgb(40, 167, 69)).darken(40)",
    "uncommon": "rgb(117, 128, 142)",
    "on-uncommon": "new TinyColor(rgb(117, 128, 142)).darken(40)"
}
  )
    .addColorVariant('border','#2b2e39', ['on-sidebar'])
    .addColorVariant('border','#2b2e39', ['on-background'])
    .addColorVariant('hover','#404552', ['background'])
    .addColorVariant('active','#484c5b', ['background'])
    .addColorVariant('selected','rgb(84, 128, 226)', ['background'])
    .addColorVariant('selected','#ffffff', ['on-background'])
    .addColorVariant('muted','#9eaabd', ['on-background'])
    .addColorVariant('link','rgb( 48, 144, 255)', ['on-background'])

const arcLight = new Theme()
  .setName('arc-light')
  .addColors(
{
    "accent": "rgb(84, 128, 226)",
    "sidebar": "#313742",
    "on-sidebar": "#d3dae3",
    "toolbar": "#f6f8fa",
    "on-toolbar": "#5c616c",
    "background": "#ffffff",
    "on-background": "#5c616c",
    "error": "rgb(215, 58, 73)",
    "on-error": "new TinyColor(rgb(215, 58, 73)).darken(40)",
    "warning": "rgb(219, 171, 9)",
    "on-warning": "new TinyColor(rgb(219, 171, 9)).darken(40)",
    "success": "rgb(40, 167, 69)",
    "on-success": "new TinyColor(rgb(40, 167, 69)).darken(40)",
    "uncommon": "rgb(117, 128, 142)",
    "on-uncommon": "new TinyColor(rgb(117, 128, 142)).darken(40)"
}
  )
    .addColorVariant('border','#2b2e39', ['on-sidebar'])
    .addColorVariant('border','#e1e4e8', ['on-background'])
    .addColorVariant('hover','#f2f2f2', ['background'])
    .addColorVariant('active','#e5e5e5', ['background'])
    .addColorVariant('selected','rgb(84, 128, 226)', ['background'])
    .addColorVariant('selected','#ffffff', ['on-background'])
    .addColorVariant('muted','#6a6f7c', ['on-background'])
    .addColorVariant('link','rgb( 48, 144, 255)', ['on-background'])

const nordDark = new Theme()
  .setName('nord-dark')
  .addColors(
{
    "accent": "rgb(143, 188, 187)",
    "sidebar": "#353c4a",
    "on-sidebar": "#d3dae3",
    "toolbar": "#353c4a",
    "on-toolbar": "#d8dee9",
    "background": "#2e3440",
    "on-background": "#d8dee9",
    "error": "rgb(191, 97, 106)",
    "on-error": "new TinyColor(rgb(191, 97, 106)).darken(40)",
    "warning": "rgb(163, 190, 140)",
    "on-warning": "new TinyColor(rgb(163, 190, 140)).darken(40)",
    "success": "rgb(163, 190, 140)",
    "on-success": "new TinyColor(rgb(163, 190, 140)).darken(40)",
    "uncommon": "rgb(117, 128, 142)",
    "on-uncommon": "new TinyColor(rgb(117, 128, 142)).darken(40)"
}
  )
    .addColorVariant('border','#232831', ['on-sidebar'])
    .addColorVariant('border','#272b35', ['on-background'])
    .addColorVariant('hover','#3b4252', ['background'])
    .addColorVariant('active','#434c5e', ['background'])
    .addColorVariant('selected','rgb(143, 188, 187)', ['background'])
    .addColorVariant('selected','#ffffff', ['on-background'])
    .addColorVariant('muted','#a4b2cc', ['on-background'])
    .addColorVariant('link','rgb( 48, 144, 255)', ['on-background'])

const nordLight = new Theme()
  .setName('nord-light')
  .addColors(
{
    "accent": "rgb(143, 188, 187)",
    "sidebar": "#353c4a",
    "on-sidebar": "#d3dae3",
    "toolbar": "#d8dee9",
    "on-toolbar": "#24292e",
    "background": "#e5e9f0",
    "on-background": "#24292e",
    "error": "rgb(191, 97, 106)",
    "on-error": "new TinyColor(rgb(191, 97, 106)).darken(40)",
    "warning": "rgb(163, 190, 140)",
    "on-warning": "new TinyColor(rgb(163, 190, 140)).darken(40)",
    "success": "rgb(163, 190, 140)",
    "on-success": "new TinyColor(rgb(163, 190, 140)).darken(40)",
    "uncommon": "rgb(117, 128, 142)",
    "on-uncommon": "new TinyColor(rgb(117, 128, 142)).darken(40)"
}
  )
    .addColorVariant('border','#232831', ['on-sidebar'])
    .addColorVariant('border','#bec8da', ['on-background'])
    .addColorVariant('hover','#d2d9e5', ['background'])
    .addColorVariant('active','#cbd3e1', ['background'])
    .addColorVariant('selected','rgb(143, 188, 187)', ['background'])
    .addColorVariant('selected','#ffffff', ['on-background'])
    .addColorVariant('muted','#6a737d', ['on-background'])
    .addColorVariant('link','rgb( 48, 144, 255)', ['on-background'])

const primerDark = new Theme()
  .setName('primer-dark')
  .addColors(
{
    "accent": "rgb(3, 102, 214)",
    "sidebar": "#1d2125",
    "on-sidebar": "#d1d5da",
    "toolbar": "#2f363d",
    "on-toolbar": "#d1d5da",
    "background": "#24292e",
    "on-background": "#d1d5da",
    "error": "rgb(215, 58, 73)",
    "on-error": "new TinyColor(rgb(215, 58, 73)).darken(40)",
    "warning": "rgb(219, 171, 9)",
    "on-warning": "new TinyColor(rgb(219, 171, 9)).darken(40)",
    "success": "rgb(40, 167, 69)",
    "on-success": "new TinyColor(rgb(40, 167, 69)).darken(40)",
    "uncommon": "rgb(117, 128, 142)",
    "on-uncommon": "new TinyColor(rgb(117, 128, 142)).darken(40)"
}
  )
    .addColorVariant('border','#141414', ['on-sidebar'])
    .addColorVariant('border','#141414', ['on-background'])
    .addColorVariant('hover','#2f363d', ['background'])
    .addColorVariant('active','#444d56', ['background'])
    .addColorVariant('selected','rgb(3, 102, 214)', ['background'])
    .addColorVariant('selected','#ffffff', ['on-background'])
    .addColorVariant('muted','#959da5', ['on-background'])
    .addColorVariant('link','rgb( 48, 144, 255)', ['on-background'])

const primerLight = new Theme()
  .setName('primer-light')
  .addColors(
{
    "accent": "rgb(3, 102, 214)",
    "sidebar": "#1d2125",
    "on-sidebar": "#d1d5da",
    "toolbar": "#f6f8fa",
    "on-toolbar": "#24292e",
    "background": "#ffffff",
    "on-background": "#24292e",
    "error": "rgb(215, 58, 73)",
    "on-error": "new TinyColor(rgb(215, 58, 73)).darken(40)",
    "warning": "rgb(219, 171, 9)",
    "on-warning": "new TinyColor(rgb(219, 171, 9)).darken(40)",
    "success": "rgb(40, 167, 69)",
    "on-success": "new TinyColor(rgb(40, 167, 69)).darken(40)",
    "uncommon": "rgb(117, 128, 142)",
    "on-uncommon": "new TinyColor(rgb(117, 128, 142)).darken(40)"
}
  )
    .addColorVariant('border','#141414', ['on-sidebar'])
    .addColorVariant('border','#e1e4e8', ['on-background'])
    .addColorVariant('hover','#f2f2f2', ['background'])
    .addColorVariant('active','#e5e5e5', ['background'])
    .addColorVariant('selected','rgb(3, 102, 214)', ['background'])
    .addColorVariant('selected','#ffffff', ['on-background'])
    .addColorVariant('muted','#6a737d', ['on-background'])
    .addColorVariant('link','rgb( 48, 144, 255)', ['on-background'])

const yaruDark = new Theme()
  .setName('yaru-dark')
  .addColors(
{
    "accent": "rgb(233, 84, 32)",
    "sidebar": "#2b2929",
    "on-sidebar": "#F7F7F7",
    "toolbar": "#474747",
    "on-toolbar": "#F7F7F7",
    "background": "#3D3D3D",
    "on-background": "#F7F7F7",
    "error": "rgb(215, 58, 73)",
    "on-error": "new TinyColor(rgb(215, 58, 73)).darken(40)",
    "warning": "rgb(219, 171, 9)",
    "on-warning": "new TinyColor(rgb(219, 171, 9)).darken(40)",
    "success": "rgb(40, 167, 69)",
    "on-success": "new TinyColor(rgb(40, 167, 69)).darken(40)",
    "uncommon": "rgb(117, 128, 142)",
    "on-uncommon": "new TinyColor(rgb(117, 128, 142)).darken(40)"
}
  )
    .addColorVariant('border','#333333', ['on-sidebar'])
    .addColorVariant('border','#323233', ['on-background'])
    .addColorVariant('hover','#474747', ['background'])
    .addColorVariant('active','#5D5D5D', ['background'])
    .addColorVariant('selected','rgb(233, 84, 32)', ['background'])
    .addColorVariant('selected','#ffffff', ['on-background'])
    .addColorVariant('muted','#878787', ['on-background'])
    .addColorVariant('link','rgb( 48, 144, 255)', ['on-background'])

const yaruLight = new Theme()
  .setName('yaru-light')
  .addColors(
{
    "accent": "rgb(233, 84, 32)",
    "sidebar": "#2b2929",
    "on-sidebar": "#F7F7F7",
    "toolbar": "#f6f8fa",
    "on-toolbar": "#000000",
    "background": "#ffffff",
    "on-background": "#000000",
    "error": "rgb(215, 58, 73)",
    "on-error": "new TinyColor(rgb(215, 58, 73)).darken(40)",
    "warning": "rgb(219, 171, 9)",
    "on-warning": "new TinyColor(rgb(219, 171, 9)).darken(40)",
    "success": "rgb(40, 167, 69)",
    "on-success": "new TinyColor(rgb(40, 167, 69)).darken(40)",
    "uncommon": "rgb(117, 128, 142)",
    "on-uncommon": "new TinyColor(rgb(117, 128, 142)).darken(40)"
}
  )
    .addColorVariant('border','#333333', ['on-sidebar'])
    .addColorVariant('border','#e1e4e8', ['on-background'])
    .addColorVariant('hover','#f2f2f2', ['background'])
    .addColorVariant('active','#e5e5e5', ['background'])
    .addColorVariant('selected','rgb(233, 84, 32)', ['background'])
    .addColorVariant('selected','#ffffff', ['on-background'])
    .addColorVariant('muted','#333333', ['on-background'])
    .addColorVariant('link','rgb( 48, 144, 255)', ['on-background'])

module.exports = new ThemeManager()
    .setDefaultTheme(arcLight.targetable())
    .setDefaultLightTheme(arcLight.targetable())
    .setDefaultDarkTheme(arcDark.targetable())
    .addTheme(nordDark.targetable())
    .addTheme(nordLight.targetable())
    .addTheme(primerDark.targetable())
    .addTheme(primerLight.targetable())
    .addTheme(yaruDark.targetable())
    .addTheme(yaruLight.targetable())
;