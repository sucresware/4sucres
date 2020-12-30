const TInput = {
    fixedClasses: "w-full px-3 py-3 text-sm leading-tight bg-white border rounded appearance-none focus:outline-none focus:shadow-outline",
    classes: "border-on-background-border bg-background-default",
    variants: {
        error: "border-red-500 mb-1"
    }
};

const TButton = {
    fixedClasses: "focus:outline-none focus:shadow-outline inline-block transition-all ease-in-out duration-150 text-sm font-medium rounded-button",
    classes: "text-center text-on-background-default bg-background-default hover:bg-background-selected hover:text-on-background-selected px-2 py-2 shadow",
    variants: {
        secondary: "text-center text-on-background-muted hover:bg-background-default hover:text-on-background-default px-2 py-2",
        sidebar: "mx-auto flex items-center justify-center w-10 h-10 mr-2 md:mr-auto md:mb-2 rounded ring-1 bg-on-sidebar-button-background ring-on-sidebar-button-border focus:ring-accent-default",
        dropdown: "text-left w-full px-2 py-2 hover:bg-gray-100 focus:outline-none focus:bg-gray-100",
        large: "text-center text-white bg-brand-500 hover:bg-brand-600 focus:border-brand-700 active:bg-brand-700 px-4 py-3 text-base",
        link: "px-2 py-2 text-center text-gray-300 hover:text-gray-100"
    }
};

const TDropdown = {
    fixedClasses: {
        button: "p-3",
        wrapper: "inline-flex flex-col",
        dropdownWrapper: "relative z-10",
        dropdown: "transform absolute shadow-md bg-background-alt text-on-background-default rounded-default",
        enterClass: "",
        enterActiveClass: "transition ease-out duration-100 transform opacity-0 scale-95",
        enterToClass: "transform opacity-100 scale-100",
        leaveClass: "transition ease-in transform opacity-100 scale-100",
        leaveActiveClass: "",
        leaveToClass: "transform opacity-0 scale-95 duration-75"
    },
    classes: {
        dropdown: "origin-top-right right-0"
    },
    variants: {
        sidebar: {
            dropdown: "-translate-x-full-minus-4 -translate-y-full-plus-14 md:-translate-y-full-plus-4 md:translate-x-14 w-64 sm:w-72"
        },
    }
};

const settings = {
    TInput,
    TButton,
    TDropdown
};

export default settings;
