import { SVGAttributes } from 'react';

export default function AppLogoIcon(props: SVGAttributes<SVGElement>) {
    return (
        <svg {...props} viewBox="0 0 42 33" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="21.138" cy="16.5" r="15" stroke="#000" strokeWidth="3"/>
            <path d="M21.138 15c-4.4-5.2-11-2.167-13.5 0 1.6-10.4 9.333-12 13-12 10.4.4 13.667 8.167 14 12-6.4-5.6-11.5-2.333-13.5 0Z" fill="#000" stroke="#000"/>
            <circle cx="13" cy="17" r="2" fill="#FFA8BA"/>
            <circle cx="29" cy="17" r="2" fill="#FFA8BA"/>
            <path d="M5.638 11.5c-3.5 5.167-8.4 14.2 0 9v-9ZM36.638 11.5c3.5 5.167 8.4 14.2 0 9v-9Z" fill="#000" stroke="#000"/>
            <path d="M21.736 18.768a1.28 1.28 0 0 1-1.472 0l-2.879-2.117c-.778-.572-.298-1.651.736-1.651h5.758c1.034 0 1.514 1.079.736 1.651l-2.88 2.117Z" fill="#FAAE2B"/>
        </svg>
);
}
