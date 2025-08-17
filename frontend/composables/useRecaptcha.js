export const useRecaptcha = () => {
    const loadRecaptcha = () => {
        return new Promise((resolve, reject) => {
            if (window.grecaptcha) return resolve(window.grecaptcha);
    
            const script = document.createElement("script");
            script.src = `https://www.google.com/recaptcha/api.js?render=${import.meta.env.VITE_RECAPTCHA_SITE_KEY}`;
            script.async = true;
            script.onload = () => {
            resolve(window.grecaptcha);
            };
            script.onerror = () => reject("Failed to load reCAPTCHA");
            document.head.appendChild(script);
        });
        };
    
        const getToken = async (action = "submit") => {
        const grecaptcha = await loadRecaptcha();
        return grecaptcha.execute(import.meta.env.VITE_RECAPTCHA_SITE_KEY, { action });
        };
    
        return {
        getToken,
        };
    };
    