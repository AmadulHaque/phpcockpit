import './bootstrap';
import { Alpine, Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('consoleStream', (autoScroll = true) => ({
        autoScroll,
        onOutputUpdated() {
            if (!this.autoScroll) {
                return;
            }

            this.$nextTick(() => {
                const output = this.$refs.output;

                if (!output) {
                    return;
                }

                output.scrollTo({
                    top: output.scrollHeight,
                    behavior: 'smooth',
                });
            });
        },
    }));

    Alpine.data('tinkerEditor', () => ({
        lineCount: 1,
        syncFromValue(value, gutter = null, textarea = null) {
            this.lineCount = Math.max(1, (value || '').split('\n').length);

            if (gutter && textarea) {
                gutter.scrollTop = textarea.scrollTop;
            }
        },
        insertTab(event) {
            const textarea = event.target;
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;

            textarea.value = `${textarea.value.substring(0, start)}    ${textarea.value.substring(end)}`;
            textarea.selectionStart = textarea.selectionEnd = start + 4;
            textarea.dispatchEvent(new Event('input', { bubbles: true }));
        },
    }));
});

Livewire.start();
