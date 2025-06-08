<template>
    <div class="global-scroll-buttons">
        <!-- Scroll to Top -->
        <button
            v-if="isScrollable && !atTop"
            class="btn-floating"
            @click="scrollToTop"
            aria-label="Scroll to top"
            title="Scroll to top"
        >
            <svg
                class="arrow-icon arrow-icon-top"
                viewBox="0 0 24 24"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M12 9L6 15H18L12 9Z" />
            </svg>
        </button>

        <!-- Scroll to Bottom -->
        <button
            v-if="isScrollable && !atBottom"
            class="btn-floating"
            @click="scrollToBottom"
            aria-label="Scroll to bottom"
            title="Scroll to bottom"
        >
            <svg
                class="arrow-icon arrow-icon-bottom"
                viewBox="0 0 24 24"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M12 15L6 9H18L12 15Z" />
            </svg>
        </button>
    </div>
</template>

<script>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue'

export default {
    name: 'FloatingScrollButtons',
    setup() {
        const atTop = ref(true)
        const atBottom = ref(false)
        const isScrollable = ref(false)

        const checkScroll = () => {
            const scrollTop = window.scrollY || document.documentElement.scrollTop
            const windowHeight = window.innerHeight || document.documentElement.clientHeight
            const docHeight = Math.max(
                document.body.scrollHeight, document.documentElement.scrollHeight,
                document.body.offsetHeight, document.documentElement.offsetHeight,
                document.body.clientHeight, document.documentElement.clientHeight
            )

            isScrollable.value = docHeight > windowHeight
            atTop.value = scrollTop <= 0
            atBottom.value = scrollTop + windowHeight >= docHeight - 1 // 1px fudge for rounding errors
        }

        const scrollToTop = () => {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
            window.scrollTo({
                top: 0,
                behavior: prefersReducedMotion ? 'auto' : 'smooth'
            })
        }

        const scrollToBottom = () => {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: prefersReducedMotion ? 'auto' : 'smooth'
            })
        }

        onMounted(() => {
            window.addEventListener('scroll', checkScroll, { passive: true })
            nextTick(() => {
                setTimeout(checkScroll, 200)
            })
        })

        onBeforeUnmount(() => {
            window.removeEventListener('scroll', checkScroll)
        })

        return {
            atTop,
            atBottom,
            isScrollable,
            scrollToTop,
            scrollToBottom,
        }
    },
}
</script>


<style scoped>
.global-scroll-buttons {
    position: fixed;
    right: 1rem;
    bottom: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    z-index: 9999; /* Keep on top of Nova content */
}

.btn-floating {
    display: inline-flex;          /* Use flex to center the icon */
    align-items: center;
    justify-content: center;
    background: #444;
    color: #fff;                   /* Icon inherits this color (fill="currentColor") */
    border-radius: 50%;
    width: 2.5rem;                 /* Circle dimension */
    height: 2.5rem;
    cursor: pointer;
    border: none;
    outline: none;
    transition: background 0.2s;
}

.btn-floating:hover {
    background: #222;
}

.btn-floating:focus {
    outline: 2px solid #6c63ff;
    outline-offset: 2px;
}

.arrow-icon {
    width: 1.25rem;
    height: 1.25rem;
    display: block;   /* removes default inline SVG spacing */
}

.arrow-icon-top {
    transform: translateY(-1px); /* Shift the arrow 1px higher */
}

.arrow-icon-bottom {
    transform: translateY(1px);
}
</style>
