const { Theme, ThemeManager } = require('tailwindcss-theming/api');

const sucresWareLight = new Theme()
  .setName('sucresware-light')
  .addColors({
    "accent": "#0060BE",
    "on-accent": "#FFFFFF",
    "sidebar": "#212437",
    "on-sidebar": "#FFFFFF",
    "toolbar": "#FAF7FE",
    "on-toolbar": "#5C5881",
    "background": "#ffffff",
    "on-background": "#6D6D89",
    "error": "#FF5B73",
    "on-error": "#81232c",
    "warning": "#FFC621",
    "on-warning": "#846706",
    "success": "#42C353",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#FF5B73",
    "gray": "#75808e",
    "yellow": "#FFC621",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#42C353",
    "blue": "#0060BE"
})
  .addColorVariant("border","#E9ECF6","on-background")
  .addColorVariant("border","#E9ECF6","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#303247","on-sidebar")
  .addColorVariant("hover","rgba(255, 255, 255, .5)","toolbar")
  .addColorVariant("active","#ffffff","toolbar")
  .addColorVariant("selected","#ffffff","toolbar")
  .addColorVariant("selected","#5C5881","on-toolbar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#5480e2","background")
  .addColorVariant("selected","#ffffff","on-background")
  .addColorVariant("muted","#6a6f7c","on-background")
  .addColorVariant("link","#3090ff","on-background")
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
  .setVariable("avatar","32px","width","avatar-width")
  .setVariable("avatar-lg","48px","width","avatar-width")
  .setVariable("avatar-xl","64px","width","avatar-width")
  .setVariable("none","1","lineHeight","leading")
  .setVariable("normal","1.5","lineHeight","leading")
  .setVariable("semibold","600","fontWeight","font-weight")
  .setVariable("bold","700","fontWeight","font-weight")
  .setVariable("light","300","fontWeight","font-weight")
  .setVariable("normal","400","fontWeight","font-weight")
  .setVariable("avatar","100%","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")
  .setVariable("sans",["Inter","sans-serif"],"fontFamily","font")
const arcDark = new Theme()
  .setName('arc-dark')
  .addColors({
    "accent": "#5480e2",
    "on-accent": "#ffffff",
    "sidebar": "#313742",
    "on-sidebar": "#d3dae3",
    "toolbar": "#404552",
    "on-toolbar": "#d3dae3",
    "background": "#373d48",
    "on-background": "#d3dae3",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#2b2e39","on-background")
  .addColorVariant("border","#2b2e39","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#404552","on-sidebar")
  .addColorVariant("hover","#404552","toolbar")
  .addColorVariant("active","#484c5b","toolbar")
  .addColorVariant("selected","#484c5b","toolbar")
  .addColorVariant("selected","#d3dae3","on-toolbar")
  .addColorVariant("hover","#404552","background")
  .addColorVariant("active","#484c5b","background")
  .addColorVariant("selected","#484c5b","background")
  .addColorVariant("selected","#d3dae3","on-background")
  .addColorVariant("muted","#9eaabd","on-background")
  .addColorVariant("link","#3090ff","on-background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")
  .setVariable("sans",["Inter","sans-serif"],"fontFamily","font")

const arcLight = new Theme()
  .setName('arc-light')
  .addColors({
    "accent": "#5480e2",
    "on-accent": "#ffffff",
    "sidebar": "#313742",
    "on-sidebar": "#d3dae3",
    "toolbar": "#ffffff",
    "on-toolbar": "#5c616c",
    "background": "#ffffff",
    "on-background": "#5c616c",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("border","#e1e4e8","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#404552","on-sidebar")
  .addColorVariant("hover","#f2f2f2","toolbar")
  .addColorVariant("active","#e5e5e5","toolbar")
  .addColorVariant("selected","#e5e5e5","toolbar")
  .addColorVariant("selected","#5c616c","on-toolbar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#e5e5e5","background")
  .addColorVariant("selected","#5c616c","on-background")
  .addColorVariant("muted","#6a6f7c","on-background")
  .addColorVariant("link","#3090ff","on-background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")
  .setVariable("sans",["Inter","sans-serif"],"fontFamily","font")

const draculaDark = new Theme()
  .setName('dracula-dark')
  .addColors({
    "accent": "#8a3ef4",
    "on-accent": "#ffffff",
    "sidebar": "#282a36",
    "on-sidebar": "#bfc5d9",
    "toolbar": "#282a36",
    "on-toolbar": "#bfc5d9",
    "background": "#22222c",
    "on-background": "#bfc5d9",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#1b1c24","on-background")
  .addColorVariant("border","#1b1c24","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#22222c","on-sidebar")
  .addColorVariant("hover","#282a36","toolbar")
  .addColorVariant("active","#343746","toolbar")
  .addColorVariant("selected","#343746","toolbar")
  .addColorVariant("selected","#bfc5d9","on-toolbar")
  .addColorVariant("hover","#282a36","background")
  .addColorVariant("active","#343746","background")
  .addColorVariant("selected","#343746","background")
  .addColorVariant("selected","#bfc5d9","on-background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")

const draculaLight = new Theme()
  .setName('dracula-light')
  .addColors({
    "accent": "#8a3ef4",
    "on-accent": "#ffffff",
    "sidebar": "#282a36",
    "on-sidebar": "#bfc5d9",
    "toolbar": "#ffffff",
    "on-toolbar": "#24292e",
    "background": "#ffffff",
    "on-background": "#24292e",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("border","#e1e4e8","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#22222c","on-sidebar")
  .addColorVariant("hover","#f2f2f2","toolbar")
  .addColorVariant("active","#e5e5e5","toolbar")
  .addColorVariant("selected","#e5e5e5","toolbar")
  .addColorVariant("selected","#24292e","on-toolbar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#e5e5e5","background")
  .addColorVariant("selected","#24292e","on-background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")

const gruvboxDark = new Theme()
  .setName('gruvbox-dark')
  .addColors({
    "accent": "#d79921",
    "on-accent": "#ffffff",
    "sidebar": "#32302f",
    "on-sidebar": "#bdae93",
    "toolbar": "#282828",
    "on-toolbar": "#ebdbb2",
    "background": "#3c3836",
    "on-background": "#ebdbb2",
    "error": "#cc241d",
    "on-error": "#7b1612",
    "warning": "#d59921",
    "on-warning": "#805c14",
    "success": "#689d6a",
    "on-success": "#3f5f40",
    "uncommon": "#a89984",
    "on-uncommon": "#655c50",
    "red": "#cc241d",
    "gray": "#a89984",
    "yellow": "#d59921",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#689d6a",
    "blue": "#4299e1"
})
  .addColorVariant("border","#1d2021","on-background")
  .addColorVariant("border","#1d2021","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#282828","on-sidebar")
  .addColorVariant("hover","#504945","toolbar")
  .addColorVariant("active","#665c54","toolbar")
  .addColorVariant("selected","#665c54","toolbar")
  .addColorVariant("selected","#ebdbb2","on-toolbar")
  .addColorVariant("hover","#504945","background")
  .addColorVariant("active","#665c54","background")
  .addColorVariant("selected","#665c54","background")
  .addColorVariant("selected","#ebdbb2","on-background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")

const gruvboxLight = new Theme()
  .setName('gruvbox-light')
  .addColors({
    "accent": "#d79921",
    "on-accent": "#ffffff",
    "sidebar": "#32302f",
    "on-sidebar": "#bdae93",
    "toolbar": "#ffffff",
    "on-toolbar": "#24292e",
    "background": "#ffffff",
    "on-background": "#24292e",
    "error": "#cc241d",
    "on-error": "#7b1612",
    "warning": "#d59921",
    "on-warning": "#805c14",
    "success": "#689d6a",
    "on-success": "#3f5f40",
    "uncommon": "#a89984",
    "on-uncommon": "#655c50",
    "red": "#cc241d",
    "gray": "#a89984",
    "yellow": "#d59921",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#689d6a",
    "blue": "#4299e1"
})
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("border","#e1e4e8","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#282828","on-sidebar")
  .addColorVariant("hover","#f2f2f2","toolbar")
  .addColorVariant("active","#e5e5e5","toolbar")
  .addColorVariant("selected","#e5e5e5","toolbar")
  .addColorVariant("selected","#24292e","on-toolbar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#e5e5e5","background")
  .addColorVariant("selected","#24292e","on-background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")

const monokaiProDark = new Theme()
  .setName('monokai-pro-dark')
  .addColors({
    "accent": "#b71c1c",
    "on-accent": "#ffffff",
    "sidebar": "#272428",
    "on-sidebar": "#c1c0c0",
    "toolbar": "#2d2a2e",
    "on-toolbar": "#c1c0c0",
    "background": "#221f22",
    "on-background": "#c1c0c0",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#19181a","on-background")
  .addColorVariant("border","#19181a","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#221f22","on-sidebar")
  .addColorVariant("hover","#2a272a","toolbar")
  .addColorVariant("active","#353135","toolbar")
  .addColorVariant("selected","#353135","toolbar")
  .addColorVariant("selected","#c1c0c0","on-toolbar")
  .addColorVariant("hover","#2a272a","background")
  .addColorVariant("active","#353135","background")
  .addColorVariant("selected","#c1c0c0","on-background")
  .addColorVariant("muted","#939293","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .addColorVariant("selected","#b71c1c","background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")

const monokaiProLight = new Theme()
  .setName('monokai-pro-light')
  .addColors({
    "accent": "#b71c1c",
    "on-accent": "#ffffff",
    "sidebar": "#272428",
    "on-sidebar": "#c1c0c0",
    "toolbar": "#ffffff",
    "on-toolbar": "#24292e",
    "background": "#ffffff",
    "on-background": "#24292e",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("border","#e1e4e8","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#221f22","on-sidebar")
  .addColorVariant("hover","#f2f2f2","toolbar")
  .addColorVariant("active","#e5e5e5","toolbar")
  .addColorVariant("selected","#e5e5e5","toolbar")
  .addColorVariant("selected","#24292e","on-toolbar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#24292e","on-background")
  .addColorVariant("muted","#6a737d","on-background")
  .addColorVariant("link","#3090ff","on-background")
  .addColorVariant("selected","#b71c1c","background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")

const nordDark = new Theme()
  .setName('nord-dark')
  .addColors({
    "accent": "#8fbcbb",
    "on-accent": "#ffffff",
    "sidebar": "#353c4a",
    "on-sidebar": "#d3dae3",
    "toolbar": "#3b4252",
    "on-toolbar": "#d8dee9",
    "background": "#2e3440",
    "on-background": "#d8dee9",
    "error": "#bf616a",
    "on-error": "#733b40",
    "warning": "#a3be8c",
    "on-warning": "#627254",
    "success": "#a3be8c",
    "on-success": "#627254",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#bf616a",
    "gray": "#75808e",
    "yellow": "#a3be8c",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#a3be8c",
    "blue": "#4299e1"
})
  .addColorVariant("border","#272b35","on-background")
  .addColorVariant("border","#272b35","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#2e3440","on-sidebar")
  .addColorVariant("hover","#3b4252","toolbar")
  .addColorVariant("active","#434c5e","toolbar")
  .addColorVariant("selected","#434c5e","toolbar")
  .addColorVariant("selected","#d8dee9","on-toolbar")
  .addColorVariant("hover","#3b4252","background")
  .addColorVariant("active","#434c5e","background")
  .addColorVariant("selected","#434c5e","background")
  .addColorVariant("selected","#d8dee9","on-background")
  .addColorVariant("muted","#a4b2cc","on-background")
  .addColorVariant("link","#3090ff","on-background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")
  .setVariable("sans",["Inter","sans-serif"],"fontFamily","font")

const nordLight = new Theme()
  .setName('nord-light')
  .addColors({
    "accent": "#8fbcbb",
    "on-accent": "#ffffff",
    "sidebar": "#353c4a",
    "on-sidebar": "#d3dae3",
    "toolbar": "#eceff4",
    "on-toolbar": "#24292e",
    "background": "#e5e9f0",
    "on-background": "#24292e",
    "error": "#bf616a",
    "on-error": "#733b40",
    "warning": "#a3be8c",
    "on-warning": "#627254",
    "success": "#a3be8c",
    "on-success": "#627254",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#bf616a",
    "gray": "#75808e",
    "yellow": "#a3be8c",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#a3be8c",
    "blue": "#4299e1"
})
  .addColorVariant("border","#bec8da","on-background")
  .addColorVariant("border","#bec8da","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#2e3440","on-sidebar")
  .addColorVariant("hover","#d2d9e5","toolbar")
  .addColorVariant("active","#cbd3e1","toolbar")
  .addColorVariant("selected","#cbd3e1","toolbar")
  .addColorVariant("selected","#24292e","on-toolbar")
  .addColorVariant("hover","#d2d9e5","background")
  .addColorVariant("active","#cbd3e1","background")
  .addColorVariant("selected","#cbd3e1","background")
  .addColorVariant("selected","#24292e","on-background")
  .addColorVariant("muted","#6a737d","on-background")
  .addColorVariant("link","#3090ff","on-background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")
  .setVariable("sans",["Inter","sans-serif"],"fontFamily","font")

const primerDark = new Theme()
  .setName('primer-dark')
  .addColors({
    "accent": "#0366d6",
    "on-accent": "#ffffff",
    "sidebar": "#1d2125",
    "on-sidebar": "#d1d5da",
    "toolbar": "#2a3036",
    "on-toolbar": "#d1d5da",
    "background": "#24292e",
    "on-background": "#d1d5da",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#141414","on-background")
  .addColorVariant("border","#141414","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#161a1d","on-sidebar")
  .addColorVariant("hover","#2f363d","toolbar")
  .addColorVariant("active","#444d56","toolbar")
  .addColorVariant("selected","#444d56","toolbar")
  .addColorVariant("selected","#d1d5da","on-toolbar")
  .addColorVariant("hover","#2f363d","background")
  .addColorVariant("active","#444d56","background")
  .addColorVariant("selected","#444d56","background")
  .addColorVariant("selected","#d1d5da","on-background")
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
  .setVariable("default","3px","borderRadius","radius")
  .setVariable("button","2px","borderRadius","radius")

const primerLight = new Theme()
  .setName('primer-light')
  .addColors({
    "accent": "#0366d6",
    "on-accent": "#ffffff",
    "sidebar": "#1d2125",
    "on-sidebar": "#d1d5da",
    "toolbar": "#ffffff",
    "on-toolbar": "#24292e",
    "background": "#ffffff",
    "on-background": "#24292e",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("border","#e1e4e8","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#161a1d","on-sidebar")
  .addColorVariant("hover","#f2f2f2","toolbar")
  .addColorVariant("active","#e5e5e5","toolbar")
  .addColorVariant("selected","#e5e5e5","toolbar")
  .addColorVariant("selected","#24292e","on-toolbar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#e5e5e5","background")
  .addColorVariant("selected","#24292e","on-background")
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
  .setVariable("default","3px","borderRadius","radius")
  .setVariable("button","2px","borderRadius","radius")

const solarizedDark = new Theme()
  .setName('solarized-dark')
  .addColors({
    "accent": "#2aa198",
    "on-accent": "#ffffff",
    "sidebar": "#002b36",
    "on-sidebar": "#c5d0d3",
    "toolbar": "#05262e",
    "on-toolbar": "#a8b8bd",
    "background": "#002b36",
    "on-background": "#a8b8bd",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#03171c","on-background")
  .addColorVariant("border","#03171c","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#05262e","on-sidebar")
  .addColorVariant("hover","rgba(255,255,255,0.1)","toolbar")
  .addColorVariant("active","rgba(255,255,255,0.2)","toolbar")
  .addColorVariant("selected","rgba(255,255,255,0.2)","toolbar")
  .addColorVariant("selected","#a8b8bd","on-toolbar")
  .addColorVariant("hover","rgba(255,255,255,0.1)","background")
  .addColorVariant("active","rgba(255,255,255,0.2)","background")
  .addColorVariant("selected","rgba(255,255,255,0.2)","background")
  .addColorVariant("selected","#a8b8bd","on-background")
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
  .setVariable("avatar","100%","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")

const solarizedLight = new Theme()
  .setName('solarized-light')
  .addColors({
    "accent": "#2aa198",
    "on-accent": "#ffffff",
    "sidebar": "#002b36",
    "on-sidebar": "#c5d0d3",
    "toolbar": "#fdf6e3",
    "on-toolbar": "#586e75",
    "background": "#eee8d5",
    "on-background": "#586e75",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#dacea4","on-background")
  .addColorVariant("border","#dacea4","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#05262e","on-sidebar")
  .addColorVariant("hover","rgba(0,0,0,0.05)","toolbar")
  .addColorVariant("active","rgba(0,0,0,0.1)","toolbar")
  .addColorVariant("selected","rgba(0,0,0,0.1)","toolbar")
  .addColorVariant("selected","#586e75","on-toolbar")
  .addColorVariant("hover","rgba(0,0,0,0.05)","background")
  .addColorVariant("active","rgba(0,0,0,0.1)","background")
  .addColorVariant("selected","rgba(0,0,0,0.1)","background")
  .addColorVariant("selected","#586e75","on-background")
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
  .setVariable("avatar","100%","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")

const twitchDark = new Theme()
  .setName('twitch-dark')
  .addColors({
    "accent": "#4b367c",
    "on-accent": "#ffffff",
    "sidebar": "#4b367c",
    "on-sidebar": "#e6e6e6",
    "toolbar": "#0f0e11",
    "on-toolbar": "#c0c0c0",
    "background": "#19171c",
    "on-background": "#c0c0c0",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","rgba(255,255,255,0.05)","on-background")
  .addColorVariant("border","rgba(255,255,255,0.05)","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","rgba(0,0,0,0.25)","on-sidebar")
  .addColorVariant("hover","#232127","toolbar")
  .addColorVariant("active","#2d2a32","toolbar")
  .addColorVariant("selected","#2d2a32","toolbar")
  .addColorVariant("selected","#c0c0c0","on-toolbar")
  .addColorVariant("hover","#232127","background")
  .addColorVariant("active","#2d2a32","background")
  .addColorVariant("selected","#2d2a32","background")
  .addColorVariant("selected","#c0c0c0","on-background")
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
  .setVariable("default","3px","borderRadius","radius")
  .setVariable("button","2px","borderRadius","radius")

const twitchLight = new Theme()
  .setName('twitch-light')
  .addColors({
    "accent": "#4b367c",
    "on-accent": "#ffffff",
    "sidebar": "#4b367c",
    "on-sidebar": "#e6e6e6",
    "toolbar": "#ffffff",
    "on-toolbar": "#24292e",
    "background": "#ffffff",
    "on-background": "#24292e",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("border","#e1e4e8","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","rgba(0,0,0,0.25)","on-sidebar")
  .addColorVariant("hover","#f2f2f2","toolbar")
  .addColorVariant("active","#e5e5e5","toolbar")
  .addColorVariant("selected","#e5e5e5","toolbar")
  .addColorVariant("selected","#24292e","on-toolbar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#e5e5e5","background")
  .addColorVariant("selected","#24292e","on-background")
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
  .setVariable("default","3px","borderRadius","radius")
  .setVariable("button","2px","borderRadius","radius")

const yaruDark = new Theme()
  .setName('yaru-dark')
  .addColors({
    "accent": "#e95420",
    "on-accent": "#ffffff",
    "sidebar": "#2b2929",
    "on-sidebar": "#F7F7F7",
    "toolbar": "#353535",
    "on-toolbar": "#F7F7F7",
    "background": "#3D3D3D",
    "on-background": "#F7F7F7",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#323233","on-background")
  .addColorVariant("border","#323233","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#454545","on-sidebar")
  .addColorVariant("hover","#474747","toolbar")
  .addColorVariant("active","#5D5D5D","toolbar")
  .addColorVariant("selected","#5D5D5D","toolbar")
  .addColorVariant("selected","#F7F7F7","on-toolbar")
  .addColorVariant("hover","#474747","background")
  .addColorVariant("active","#5D5D5D","background")
  .addColorVariant("selected","#5D5D5D","background")
  .addColorVariant("selected","#F7F7F7","on-background")
  .addColorVariant("muted","#878787","on-background")
  .addColorVariant("link","#3090ff","on-background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")
  .setVariable("sans",["Inter","sans-serif"],"fontFamily","font")

const yaruLight = new Theme()
  .setName('yaru-light')
  .addColors({
    "accent": "#e95420",
    "on-accent": "#ffffff",
    "sidebar": "#2b2929",
    "on-sidebar": "#F7F7F7",
    "toolbar": "#f5f6f7",
    "on-toolbar": "#000000",
    "background": "#ffffff",
    "on-background": "#000000",
    "error": "#d73a49",
    "on-error": "#81232c",
    "warning": "#dbab09",
    "on-warning": "#846706",
    "success": "#28a745",
    "on-success": "#18652a",
    "uncommon": "#75808e",
    "on-uncommon": "#474d56",
    "red": "#d73a49",
    "gray": "#75808e",
    "yellow": "#dbab09",
    "purple": "#593695",
    "orange": "#FE921B",
    "green": "#28a745",
    "blue": "#4299e1"
})
  .addColorVariant("border","#e1e4e8","on-background")
  .addColorVariant("border","#e1e4e8","on-toolbar")
  .addColorVariant("button-background","transparent","on-sidebar")
  .addColorVariant("button-background-hover","#454545","on-sidebar")
  .addColorVariant("hover","#f2f2f2","toolbar")
  .addColorVariant("active","#e5e5e5","toolbar")
  .addColorVariant("selected","#e5e5e5","toolbar")
  .addColorVariant("selected","#000000","on-toolbar")
  .addColorVariant("hover","#f2f2f2","background")
  .addColorVariant("active","#e5e5e5","background")
  .addColorVariant("selected","#e5e5e5","background")
  .addColorVariant("selected","#000000","on-background")
  .addColorVariant("muted","#333333","on-background")
  .addColorVariant("link","#3090ff","on-background")
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
  .setVariable("avatar","5px","borderRadius","radius")
  .setVariable("default","6px","borderRadius","radius")
  .setVariable("button","6px","borderRadius","radius")
  .setVariable("sans",["Inter","sans-serif"],"fontFamily","font")

module.exports = new ThemeManager()
  .setDefaultTheme(sucresWareLight.targetable())
  // .addTheme(sucresWareDark.targetable())
  .addTheme(arcLight.targetable())
  .addTheme(arcDark.targetable())
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