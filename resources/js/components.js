// import {
//   TInput,
//   TTextarea,
//   TSelect,
//   TRadio,
//   TCheckbox,
//   TButton,
//   TInputGroup,
//   TCard,
//   TAlert,
//   TModal,
//   TDropdown,
//   TRichSelect,
//   TPagination,
//   TTag,
//   TRadioGroup,
//   TCheckboxGroup,
//   TTable,
//   TDatepicker,
//   TToggle,
//   TDialog,
// } from 'vue-tailwind/dist/components';

import TCard from 'vue-tailwind/dist/t-card';
import TInput from 'vue-tailwind/dist/t-input';
import TTextarea from 'vue-tailwind/dist/t-textarea';
import TButton from 'vue-tailwind/dist/t-button';
import TDropdown from 'vue-tailwind/dist/t-dropdown';

const components = {
  't-card': {
    component: TCard,
    props: {
      classes: {
        wrapper: 'shadow bg-background-default text-on-background-default rounded-default',
        body: 'p-4',
        header: 'border-b border-on-background-border p-4 rounded-t-default',
        footer: 'border-on-background-border bg-toolbar-default text-on-toolbar-default border-t p-4 rounded-b-default',
      },
      variants: {},
    },
  },
  't-input': {
    component: TInput,
    props: {
      fixedClasses:
        'w-full px-3 py-3 text-sm leading-tight bg-white border rounded appearance-none focus:outline-none focus:shadow-outline',
      classes: 'border-on-background-border bg-background-default',
      variants: {
        error: 'border-red-500 mb-1',
      },
    },
  },
  't-textarea': {
    component: TTextarea,
    props: {
      fixedClasses:
        'w-full px-3 py-3 text-sm leading-tight bg-white border rounded appearance-none focus:outline-none focus:shadow-outline',
      classes: 'border-on-background-border bg-background-default',
      variants: {
        error: 'border-red-500 mb-1',
      },
    },
  },
  't-button': {
    component: TButton,
    props: {
      fixedClasses: 'focus:outline-none inline-block text-sm font-medium',
      classes:
        'text-center text-on-background-default bg-background-default hover:bg-background-selected hover:text-on-background-selected px-2 py-2 shadow rounded-button',
      variants: {
        secondary:
          'text-center text-on-background-muted hover:bg-background-default hover:text-on-background-default px-2 py-2 rounded-button',
        sidebar:
          'w-12 h-full md:h-12 md:w-full flex items-center justify-center bg-on-sidebar-button-background hover:bg-on-sidebar-button-background-hover text-on-sidebar',
        dropdown: 'text-left w-full px-2 py-2 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 rounded-button',
        link: 'px-2 py-2 text-center text-gray-300 hover:text-gray-100 rounded-button',
      },
    },
  },
  't-dropdown': {
    component: TDropdown,
    props: {
      fixedClasses: {
        button: 'p-3',
        wrapper: 'flex flex-col',
        dropdownWrapper: 'relative z-10',
        dropdown: 'transform absolute shadow-md bg-background-default text-on-background-default rounded-default',
        enterClass: 'ease-out duration-100 transform',
        enterActiveClass: 'transition opacity-0 scale-95',
        enterToClass: 'transform opacity-100 scale-100',
        leaveClass: 'transition ease-in transform opacity-100 scale-100',
        leaveActiveClass: '',
        leaveToClass: 'transform opacity-0 scale-95 duration-75',
      },
      classes: {
        dropdown: 'origin-top-right right-0',
      },
      variants: {
        sidebar: {
          wrapper: 'w-12 h-full md:h-12 md:w-full items-center justify-center',
          dropdown:
            '-translate-x-full-minus-4 -translate-y-full-plus-14 md:-translate-y-full-plus-4 md:translate-x-14 w-64 sm:w-72',
        },
      },
    },
  },
};

export default components;
