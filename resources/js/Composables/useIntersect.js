import { onMounted, onUnmounted } from "vue";

export default function useInersect(ref, callback, options = {}) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                callback();
            }
        });
    }, options);

    onMounted(() => {
        observer.observe(ref.value);
    });

    onUnmounted(() => {
        observer.disconnect();
    });
}
