import { Service } from '@/types';

const bgColorValues: Record<string, string> = {
    primary: '#f5a623',
    secondary: '#f48fb1',
    accent: '#00473e',
    gray: '#f5f5f5',
    white: '#ffffff',
};

const lightBackgrounds = ['gray', 'white'];

function LinkIcon({ bgColor }: { bgColor: string }) {
    const isAccent = bgColor === 'accent';
    const circleColor = isAccent ? 'white' : 'black';
    const arrowColor = bgColorValues[bgColor] ?? '#ffffff';

    return (
        <svg width="32" height="32" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="20.5" cy="20.5" r="20.5" fill={circleColor} />
            <path
                d="M11.25 24.7009C10.5326 25.1151 10.2867 26.0325 10.701 26.7499C11.1152 27.4674 12.0326 27.7132 12.75 27.299L12 25.9999L11.25 24.7009ZM30.7694 16.3882C30.9838 15.588 30.5089 14.7655 29.7087 14.5511L16.6687 11.057C15.8685 10.8426 15.046 11.3175 14.8316 12.1177C14.6172 12.9179 15.0921 13.7404 15.8923 13.9548L27.4834 17.0606L24.3776 28.6517C24.1631 29.4519 24.638 30.2744 25.4382 30.4888C26.2384 30.7032 27.0609 30.2284 27.2753 29.4282L30.7694 16.3882ZM12 25.9999L12.75 27.299L30.0705 17.299L29.3205 15.9999L28.5705 14.7009L11.25 24.7009L12 25.9999Z"
                fill={arrowColor}
            />
        </svg>
    );
}

export function ServiceCard({ title, colorTitle, bgColor, bgTitle, descriptionColor, description, link, illustration }: Service) {
    const isLightBg = lightBackgrounds.includes(bgColor);

    return (
        <div className={`nb-shadow flex items-center gap-4 bg-${bgColor} justify-center rounded-4xl p-10`}>
            <div>
                <div className="max-w-[150px]">
                    <h3 className={`inline text-2xl font-semibold text-${colorTitle} font-medium bg-${bgTitle} rounded p-1 line-clamp-2`}>
                        {title}
                    </h3>
                </div>
                <p className={`text-sm text-${descriptionColor} mt-5`}>{description}</p>
                <a
                    href={link}
                    className={`inline-flex items-center gap-2 font-medium mt-4 hover:underline ${isLightBg ? 'text-black' : 'text-white'}`}
                >
                    <LinkIcon bgColor={bgColor} />
                    En savoir plus
                </a>
            </div>
            <div className="w-full">
                <img src={illustration} alt={title} className="w-full h-auto" />
            </div>
        </div>
    );
}
