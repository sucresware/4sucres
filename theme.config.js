const { Theme, ThemeManager } = require('tailwindcss-theming/api');
const { TinyColor } = require('@ctrl/tinycolor');

const arcDark = new Theme()
  .setName('arc-dark')
  .addColors({
    "accent": "#5480e2",
    "sidebar": "#313742",
    "on-sidebar": "#d3dae3",
    "toolbar": "#303641",
    "on-toolbar": "#d3dae3",
    "background": "#373d48",
    "on-background": "#d3dae3",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#404552","background")
  .addColorVariant("border","#2b2e39","on-sidebar")
  .addColorVariant("border","#2b2e39","on-background")
  .addColorVariant("button-background","#404552","on-sidebar")
  .addColorVariant("button-border","#2b2e39","on-sidebar")
  .addColorVariant("hover","#404552","background")
  .addColorVariant("active","#484c5b","background")
  .addColorVariant("selected","#5480e2","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#9eaabd","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const arcLight = new Theme()
  .setName('arc-light')
  .addColors({
    "accent": "#5480e2",
    "sidebar": "#313742",
    "on-sidebar": "#d3dae3",
    "toolbar": "#f6f8fa",
    "on-toolbar": "#5c616c",
    "background": "#ffffff",
    "on-background": "#5c616c",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#ffffff","background")
  .addColorVariant("border","#2b2e39","on-sidebar")
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("button-background","#404552","on-sidebar")
  .addColorVariant("button-border","#2b2e39","on-sidebar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#5480e2","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#6a6f7c","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const draculaDark = new Theme()
  .setName('dracula-dark')
  .addColors({
    "accent": "#8a3ef4",
    "sidebar": "#282a36",
    "on-sidebar": "#bfc5d9",
    "toolbar": "#282a36",
    "on-toolbar": "#bfc5d9",
    "background": "#22222c",
    "on-background": "#bfc5d9",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#282a36","background")
  .addColorVariant("border","#191a21","on-sidebar")
  .addColorVariant("border","#1b1c24","on-background")
  .addColorVariant("button-background","#22222c","on-sidebar")
  .addColorVariant("button-border","#191a21","on-sidebar")
  .addColorVariant("hover","#282a36","background")
  .addColorVariant("active","#343746","background")
  .addColorVariant("selected","#8a3ef4","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#6272a4","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const draculaLight = new Theme()
  .setName('dracula-light')
  .addColors({
    "accent": "#8a3ef4",
    "sidebar": "#282a36",
    "on-sidebar": "#bfc5d9",
    "toolbar": "#282a36",
    "on-toolbar": "#bfc5d9",
    "background": "#22222c",
    "on-background": "#bfc5d9",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#282a36","background")
  .addColorVariant("border","#191a21","on-sidebar")
  .addColorVariant("border","#1b1c24","on-background")
  .addColorVariant("button-background","#22222c","on-sidebar")
  .addColorVariant("button-border","#191a21","on-sidebar")
  .addColorVariant("hover","#282a36","background")
  .addColorVariant("active","#343746","background")
  .addColorVariant("selected","#8a3ef4","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#6272a4","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const gruvboxDark = new Theme()
  .setName('gruvbox-dark')
  .addColors({
    "accent": "#d79921",
    "sidebar": "#32302f",
    "on-sidebar": "#bdae93",
    "toolbar": "#504945",
    "on-toolbar": "#ebdbb2",
    "background": "#3c3836",
    "on-background": "#ebdbb2",
    "error": "#cc241d",
    "on-error": "new TinyColor(#cc241d).darken(40)",
    "warning": "#d59921",
    "on-warning": "new TinyColor(#d59921).darken(40)",
    "success": "#689d6a",
    "on-success": "new TinyColor(#689d6a).darken(40)",
    "uncommon": "#a89984",
    "on-uncommon": "new TinyColor(#a89984).darken(40)"
})
  .addColorVariant("alt","#282828","background")
  .addColorVariant("border","#1d2021","on-sidebar")
  .addColorVariant("border","#1d2021","on-background")
  .addColorVariant("button-background","#282828","on-sidebar")
  .addColorVariant("button-border","#1d2021","on-sidebar")
  .addColorVariant("hover","#504945","background")
  .addColorVariant("active","#665c54","background")
  .addColorVariant("selected","#d79921","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#a89984","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const gruvboxLight = new Theme()
  .setName('gruvbox-light')
  .addColors({
    "accent": "#d79921",
    "sidebar": "#32302f",
    "on-sidebar": "#bdae93",
    "toolbar": "#f6f8fa",
    "on-toolbar": "#24292e",
    "background": "#ffffff",
    "on-background": "#24292e",
    "error": "#cc241d",
    "on-error": "new TinyColor(#cc241d).darken(40)",
    "warning": "#d59921",
    "on-warning": "new TinyColor(#d59921).darken(40)",
    "success": "#689d6a",
    "on-success": "new TinyColor(#689d6a).darken(40)",
    "uncommon": "#a89984",
    "on-uncommon": "new TinyColor(#a89984).darken(40)"
})
  .addColorVariant("alt","#ffffff","background")
  .addColorVariant("border","#1d2021","on-sidebar")
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("button-background","#282828","on-sidebar")
  .addColorVariant("button-border","#1d2021","on-sidebar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#d79921","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#6a737d","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const monokaiProDark = new Theme()
  .setName('monokai-pro-dark')
  .addColors({
    "accent": "#cc9900",
    "sidebar": "#272428",
    "on-sidebar": "#c1c0c0",
    "toolbar": "#2d2a2e",
    "on-toolbar": "#c1c0c0",
    "background": "#221f22",
    "on-background": "#c1c0c0",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#2d2a2e","background")
  .addColorVariant("border","#19181a","on-sidebar")
  .addColorVariant("border","#19181a","on-background")
  .addColorVariant("button-background","#221f22","on-sidebar")
  .addColorVariant("button-border","#19181a","on-sidebar")
  .addColorVariant("hover","#2a272a","background")
  .addColorVariant("active","#353135","background")
  .addColorVariant("selected","#cc9900","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#939293","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const monokaiProLight = new Theme()
  .setName('monokai-pro-light')
  .addColors({
    "accent": "#cc9900",
    "sidebar": "#272428",
    "on-sidebar": "#c1c0c0",
    "toolbar": "#f6f8fa",
    "on-toolbar": "#24292e",
    "background": "#ffffff",
    "on-background": "#24292e",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#ffffff","background")
  .addColorVariant("border","#19181a","on-sidebar")
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("button-background","#221f22","on-sidebar")
  .addColorVariant("button-border","#19181a","on-sidebar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#cc9900","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#6a737d","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const nordDark = new Theme()
  .setName('nord-dark')
  .addColors({
    "accent": "#8fbcbb",
    "sidebar": "#353c4a",
    "on-sidebar": "#d3dae3",
    "toolbar": "#353c4a",
    "on-toolbar": "#d8dee9",
    "background": "#2e3440",
    "on-background": "#d8dee9",
    "error": "#bf616a",
    "on-error": "new TinyColor(#bf616a).darken(40)",
    "warning": "#a3be8c",
    "on-warning": "new TinyColor(#a3be8c).darken(40)",
    "success": "#a3be8c",
    "on-success": "new TinyColor(#a3be8c).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#3b4252","background")
  .addColorVariant("border","#232831","on-sidebar")
  .addColorVariant("border","#272b35","on-background")
  .addColorVariant("button-background","#2e3440","on-sidebar")
  .addColorVariant("button-border","#232831","on-sidebar")
  .addColorVariant("hover","#3b4252","background")
  .addColorVariant("active","#434c5e","background")
  .addColorVariant("selected","#8fbcbb","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#a4b2cc","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const nordLight = new Theme()
  .setName('nord-light')
  .addColors({
    "accent": "#8fbcbb",
    "sidebar": "#353c4a",
    "on-sidebar": "#d3dae3",
    "toolbar": "#d8dee9",
    "on-toolbar": "#24292e",
    "background": "#e5e9f0",
    "on-background": "#24292e",
    "error": "#bf616a",
    "on-error": "new TinyColor(#bf616a).darken(40)",
    "warning": "#a3be8c",
    "on-warning": "new TinyColor(#a3be8c).darken(40)",
    "success": "#a3be8c",
    "on-success": "new TinyColor(#a3be8c).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#eceff4","background")
  .addColorVariant("border","#232831","on-sidebar")
  .addColorVariant("border","#bec8da","on-background")
  .addColorVariant("button-background","#2e3440","on-sidebar")
  .addColorVariant("button-border","#232831","on-sidebar")
  .addColorVariant("hover","#d2d9e5","background")
  .addColorVariant("active","#cbd3e1","background")
  .addColorVariant("selected","#8fbcbb","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#6a737d","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const primerDark = new Theme()
  .setName('primer-dark')
  .addColors({
    "accent": "#0366d6",
    "sidebar": "#1d2125",
    "on-sidebar": "#d1d5da",
    "toolbar": "#2f363d",
    "on-toolbar": "#d1d5da",
    "background": "#24292e",
    "on-background": "#d1d5da",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#2a3036","background")
  .addColorVariant("border","#141414","on-sidebar")
  .addColorVariant("border","#141414","on-background")
  .addColorVariant("button-background","#161a1d","on-sidebar")
  .addColorVariant("button-border","#141414","on-sidebar")
  .addColorVariant("hover","#2f363d","background")
  .addColorVariant("active","#444d56","background")
  .addColorVariant("selected","#0366d6","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#959da5","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const primerLight = new Theme()
  .setName('primer-light')
  .addColors({
    "accent": "#0366d6",
    "sidebar": "#1d2125",
    "on-sidebar": "#d1d5da",
    "toolbar": "#f6f8fa",
    "on-toolbar": "#24292e",
    "background": "#ffffff",
    "on-background": "#24292e",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#ffffff","background")
  .addColorVariant("border","#141414","on-sidebar")
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("button-background","#161a1d","on-sidebar")
  .addColorVariant("button-border","#141414","on-sidebar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#0366d6","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#6a737d","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const solarizedDark = new Theme()
  .setName('solarized-dark')
  .addColors({
    "accent": "#2aa198",
    "sidebar": "#002b36",
    "on-sidebar": "#c5d0d3",
    "toolbar": "#073642",
    "on-toolbar": "#a8b8bd",
    "background": "#002b36",
    "on-background": "#a8b8bd",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#05262e","background")
  .addColorVariant("border","#03171c","on-sidebar")
  .addColorVariant("border","#03171c","on-background")
  .addColorVariant("button-background","#05262e","on-sidebar")
  .addColorVariant("button-border","#03171c","on-sidebar")
  .addColorVariant("hover","rgba(255,255,255,0.1)","background")
  .addColorVariant("active","rgba(255,255,255,0.2)","background")
  .addColorVariant("selected","#2aa198","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#586e75","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const solarizedLight = new Theme()
  .setName('solarized-light')
  .addColors({
    "accent": "#2aa198",
    "sidebar": "#002b36",
    "on-sidebar": "#c5d0d3",
    "toolbar": "#fdf6e3",
    "on-toolbar": "#586e75",
    "background": "#eee8d5",
    "on-background": "#586e75",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#fdf6e3","background")
  .addColorVariant("border","#03171c","on-sidebar")
  .addColorVariant("border","#dacea4","on-background")
  .addColorVariant("button-background","#05262e","on-sidebar")
  .addColorVariant("button-border","#03171c","on-sidebar")
  .addColorVariant("hover","rgba(0,0,0,0.05)","background")
  .addColorVariant("active","rgba(0,0,0,0.1)","background")
  .addColorVariant("selected","#2aa198","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#839496","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const twitchDark = new Theme()
  .setName('twitch-dark')
  .addColors({
    "accent": "#4b367c",
    "sidebar": "#4b367c",
    "on-sidebar": "#e6e6e6",
    "toolbar": "#19171c",
    "on-toolbar": "#c0c0c0",
    "background": "#19171c",
    "on-background": "#c0c0c0",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#0f0e11","background")
  .addColorVariant("border","#4b367c","on-sidebar")
  .addColorVariant("border","rgba(255,255,255,0.05)","on-background")
  .addColorVariant("button-background","rgba(0,0,0,0.25)","on-sidebar")
  .addColorVariant("button-border","rgba(255,255,255,0.2)","on-sidebar")
  .addColorVariant("hover","#232127","background")
  .addColorVariant("active","#2d2a32","background")
  .addColorVariant("selected","#4b367c","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#7d7788","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["Arial","Helvetica Neue","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const twitchLight = new Theme()
  .setName('twitch-light')
  .addColors({
    "accent": "#4b367c",
    "sidebar": "#4b367c",
    "on-sidebar": "#e6e6e6",
    "toolbar": "#f6f8fa",
    "on-toolbar": "#24292e",
    "background": "#ffffff",
    "on-background": "#24292e",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#ffffff","background")
  .addColorVariant("border","#4b367c","on-sidebar")
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("button-background","rgba(0,0,0,0.25)","on-sidebar")
  .addColorVariant("button-border","rgba(255,255,255,0.2)","on-sidebar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#4b367c","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#6a737d","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["Arial","Helvetica Neue","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const yaruDark = new Theme()
  .setName('yaru-dark')
  .addColors({
    "accent": "#e95420",
    "sidebar": "#2b2929",
    "on-sidebar": "#F7F7F7",
    "toolbar": "#474747",
    "on-toolbar": "#F7F7F7",
    "background": "#3D3D3D",
    "on-background": "#F7F7F7",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#353535","background")
  .addColorVariant("border","#333333","on-sidebar")
  .addColorVariant("border","#323233","on-background")
  .addColorVariant("button-background","#454545","on-sidebar")
  .addColorVariant("button-border","#242424","on-sidebar")
  .addColorVariant("hover","#474747","background")
  .addColorVariant("active","#5D5D5D","background")
  .addColorVariant("selected","#e95420","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#878787","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

const yaruLight = new Theme()
  .setName('yaru-light')
  .addColors({
    "accent": "#e95420",
    "sidebar": "#2b2929",
    "on-sidebar": "#F7F7F7",
    "toolbar": "#f6f8fa",
    "on-toolbar": "#000000",
    "background": "#ffffff",
    "on-background": "#000000",
    "error": "#d73a49",
    "on-error": "new TinyColor(#d73a49).darken(40)",
    "warning": "#dbab09",
    "on-warning": "new TinyColor(#dbab09).darken(40)",
    "success": "#28a745",
    "on-success": "new TinyColor(#28a745).darken(40)",
    "uncommon": "#75808e",
    "on-uncommon": "new TinyColor(#75808e).darken(40)"
})
  .addColorVariant("alt","#f5f6f7","background")
  .addColorVariant("border","#333333","on-sidebar")
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("button-background","#454545","on-sidebar")
  .addColorVariant("button-border","#242424","on-sidebar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#e95420","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#333333","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .setVariable("sans",["-apple-system","BlinkMacSystemFont","Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue","Arial","sans-serif"],"fontFamily","font")
  .setVariable("mono",["Menlo","Monaco","Consolas","Liberation Mono","Courier New","monospace"],"fontFamily","font")
  .setVariable("xs","11px","fontSize","text")
  .setVariable("sm","12px","fontSize","text")
  .setVariable("base","14px","fontSize","text")
  .setVariable("lg","16px","fontSize","text")
  .setVariable("xl","28px","fontSize","text")
  .setVariable("2xl","32px","fontSize","text")
  .setVariable("3xl","42px","fontSize","text")
  .setVariable("md","0 8px 24px rgba(0, 0, 0, 0.15)","boxShadow","shadow")
  .setVariable("lg","0 2px 7px rgba(0, 0, 0, 0.5)","boxShadow","shadow")
  .setVariable("avatar-xs","18px","width","avatar-width")
  .setVariable("avatar-sm","24px","width","avatar-width")
  .setVariable("avatar","28px","width","avatar-width")
  .setVariable("avatar-lg","45px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","calc( 3px \/ 2)","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")
  .setVariable("server","3px","borderRadius","radius")
  .setVariable("border","3px","borderRadius","radius")

module.exports = new ThemeManager()
  .setDefaultTheme(arcLight.targetable())
  .setDefaultLightTheme(arcLight.targetable())
  .setDefaultDarkTheme(arcDark.targetable())
  .addTheme(draculaDark.targetable())
  .addTheme(draculaLight.targetable())
  .addTheme(gruvboxDark.targetable())
  .addTheme(gruvboxLight.targetable())
  .addTheme(monokaiProDark.targetable())
  .addTheme(monokaiProLight.targetable())
  .addTheme(nordDark.targetable())
  .addTheme(nordLight.targetable())
  .addTheme(primerDark.targetable())
  .addTheme(primerLight.targetable())
  .addTheme(solarizedDark.targetable())
  .addTheme(solarizedLight.targetable())
  .addTheme(twitchDark.targetable())
  .addTheme(twitchLight.targetable())
  .addTheme(yaruDark.targetable())
  .addTheme(yaruLight.targetable())
;