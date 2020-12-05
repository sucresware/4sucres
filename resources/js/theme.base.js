const TInput = {
    classes: "border-2 block w-full rounded text-gray-800",
    // Optional variants
    variants: {
        // ...
    }
    // Optional fixedClasses
    // fixedClasses: '',
};

const TButton = {
    fixedClasses:
        "focus:outline-none focus:shadow-outline inline-block text-center transition ease-in-out duration-150 text-sm font-medium border border-transparent px-3 py-2 rounded-md",
    classes:
        "text-white bg-brand-500 hover:bg-brand-600 focus:border-brand-700 active:bg-brand-700",
    variants: {
        link: "px-3 py-2 text-gray-300 hover:text-gray-100 rounded",
        plarge:
            "text-white bg-gray-800 hover:bg-gray-700 focus:border-gray-700 active:bg-gray-700 px-4 py-3 text-base"
    }
};

const settings = {
    // TInput
    TButton
};

export default settings;
