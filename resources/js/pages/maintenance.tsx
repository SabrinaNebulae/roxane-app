import React, { useState, useEffect } from "react";

export default function MaintenancePage() {
    const [dark, setDark] = useState(false);

    useEffect(() => {
        if (dark) {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    }, [dark]);

    return (
        <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-6 transition-colors duration-300">
            <button
                onClick={() => setDark(!dark)}
                className="absolute top-4 right-4 px-3 py-1 rounded-xl border border-gray-400 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-800 transition"
            >
                {dark ? "☀️ Mode clair" : "🌙 Mode sombre"}
            </button>

            <h1 className="text-4xl font-bold mb-4 text-center">Site en cours de construction</h1>
            <p className="text-lg text-center max-w-xl">
                Nous effectuons actuellement une mise à jour. Le site sera de visible très bientôt.
            </p>
        </div>
    );
}
