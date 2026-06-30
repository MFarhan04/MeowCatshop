/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'merah-gelap': '#7f1d1d', // Warna merah gelap utama
                'merah-aksen': '#991b1b', // Warna merah untuk efek saat tombol disorot
            }
        },
    },
    plugins: [],
}
