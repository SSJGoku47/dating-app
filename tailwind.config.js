import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {

            // Colors 
            colors: {
                primaryBackground: '#C0DEE3', 
                primaryText: '#096776', 
                buttonBackground: '#065269', 
                primaryBlack: '#000000', 
                primaryWhite: '#FFFFFF', 
                borderPrimary: '#096776',
                
            },

            //Width
            width: {
                'sm':'300px',
                'md': '580px', 
            },

            // Height
            height: {
     
            },

            //Margin

            margin: {
                
            },

            // Components 
            borderRadius: {
                'lg': '1rem', 
            },

            // Button
            button: {
                primary: {
                    backgroundColor: '#065269', 
                    color: '#FFFFFF', 
                    padding: '0.75rem 1.5rem', 
                },
            },

            // Typography 
            fontFamily: {
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans], 
            },

            fontSize: {
                'xxs': '0.625rem',
                'xxl': '2rem',
            },

            // Spacing
            spacing: {
                '128': '32rem', 
                '144': '36rem', 
            },


            // Components 
            borderRadius: {
                'lg': '1rem', 
            },

            // Button
            button: {
                primary: {
                    backgroundColor: '#065269', 
                    color: '#FFFFFF', 
                    padding: '0.75rem 1.5rem', 
                },
            },

            // Shadows
            boxShadow: {
                'button': '0 4px 6px rgba(0, 0, 0, 0.1)', 
                'card': '0 4px 8px rgba(0, 0, 0, 0.1)', 
            },

            // Border
            borderWidth: {
                '3': '3px', 
            },
        },
    },

    plugins: [],
};
