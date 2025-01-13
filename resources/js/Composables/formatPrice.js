export default function formatPrice(price) {
    const num = parseFloat(price);
    return num % 1 === 0 ? num.toFixed(0) : num.toFixed(2);
}
