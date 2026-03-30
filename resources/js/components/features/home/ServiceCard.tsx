import {Service} from "@/types";

export function ServiceCard({title, colorTitle, bgColor, bgTitle, description, link, illustration}: Service) {
    return (
        <div
            className={`flex gap-1 items-center bg-${bgColor} justify-center gap-4 rounded-4xl p-10 border-3 border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none  hover:translate-2 transition delay-50 duration-200 ease-in-out`}>
            <div>
                <div className="max-w-[150px]">
                    <h3 className={`inline text-2xl font-semibold text-${colorTitle} font-medium bg-${bgTitle} rounded p-1 line-clamp-2`}>{title}</h3>
                </div>
                <p className="text-sm text-muted-foreground mt-5">{description}</p>
                <a href={link} className="text-white underline hover:font-medium mt-4 inline-block  hover:underline">
                    En savoir plus
                </a>
            </div>
            <div className="relative w-full h-64">
                <img
                    src={illustration}
                    alt={title}
                    className="w-full h-full object-cover rounded-lg"
                />
            </div>
        </div>
    );
}
