const TInput = {
    fixedClasses:
        "w-full px-3 py-3 text-sm leading-tight bg-white border rounded-md appearance-none focus:outline-none focus:shadow-outline",
    classes: "border-gray-300",
    variants: {
        error: "border-red-500 mb-1"
    }
};

const TButton = {
    fixedClasses:
        "focus:outline-none focus:shadow-outline inline-block transition ease-in-out duration-150 text-sm font-medium rounded-md",
    classes:
        "text-center text-white bg-brand-500 hover:bg-brand-600 focus:border-brand-700 active:bg-brand-700 px-3 py-2",
    variants: {
        sidebar:
            "mx-auto flex text-gray-300 items-center justify-center w-10 h-10 mb-4 bg-gray-800 rounded-md hover:bg-gray-900 focus:text-white focus:bg-brand-500 focus:outline-none",
        dropdown:
            "text-left w-full px-2 py-2 hover:bg-gray-100 focus:outline-none focus:bg-gray-100",
        large:
            "text-center text-white bg-brand-500 hover:bg-brand-600 focus:border-brand-700 active:bg-brand-700 px-4 py-3 text-base",
        link: "px-3 py-2 text-center text-gray-300 hover:text-gray-100"
    }
};

const TDropdown = {
    fixedClasses: {
        button: "p-3",
        wrapper: "inline-flex flex-col",
        dropdownWrapper: "relative z-10",
        dropdown: "transform absolute shadow-lg bg-white rounded-md",
        enterClass: "",
        enterActiveClass:
            "transition ease-out duration-100 transform opacity-0 scale-95",
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
            dropdown: "-translate-y-full translate-x-20 w-64 sm:w-72"
        }
    }
};

const settings = {
    TInput,
    TButton,
    TDropdown
};

export default settings;
