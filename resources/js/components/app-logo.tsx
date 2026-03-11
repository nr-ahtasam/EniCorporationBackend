import AppLogoIcon from './app-logo-icon';

type AppLogoProps = {
    logoUrl?: string;
};

export default function AppLogo({ logoUrl }: AppLogoProps) {
    return (
        <>
            <div className="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground">
                {logoUrl ? (
                    <img
                        src={logoUrl}
                        alt="Company logo"
                        className="size-8 rounded-md object-cover"
                    />
                ) : (
                    <AppLogoIcon className="size-5 fill-current text-white dark:text-black" />
                )}
            </div>
            <div className="ml-1 grid flex-1 text-left text-sm">
                <span className="mb-0.5 truncate leading-tight font-semibold">
                    Eni Corporation
                </span>
            </div>
        </>
    );
}
