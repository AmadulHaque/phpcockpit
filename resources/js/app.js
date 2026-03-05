import './bootstrap';
import { Alpine, Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('tinkerConsoleWorkbench', (environment = 'DEV') => ({
        leftCollapsed: false,
        rightCollapsed: false,
        paletteOpen: false,
        helpOpen: false,
        paletteQuery: '',
        safeMode: true,
        readOnly: false,
        prodLocked: environment === 'PROD',
        toasts: [],
        paletteActions: [
            { id: 'run', label: 'Run Command', shortcut: 'Cmd+Enter' },
            { id: 'clear', label: 'Clear Console', shortcut: 'Cmd+L' },
            { id: 'focus-snippets', label: 'Focus Snippets Search', shortcut: 'Left Panel' },
            { id: 'focus-history', label: 'Focus History Search', shortcut: 'Right Panel' },
            { id: 'toggle-help', label: 'Toggle Help Overlay', shortcut: 'Cmd+/' },
        ],
        get filteredPaletteActions() {
            const query = this.paletteQuery.trim().toLowerCase();

            if (query === '') {
                return this.paletteActions;
            }

            return this.paletteActions.filter((action) => action.label.toLowerCase().includes(query));
        },
        init() {
            this.applySafety('safeMode');
            this.applySafety('readOnly');

            if (environment === 'PROD') {
                this.applySafety('prodLocked');
            }
        },
        pushToast(detail = {}) {
            if (!detail.message) {
                return;
            }

            const id = Date.now() + Math.random();

            this.toasts.push({
                id,
                type: detail.type ?? 'info',
                message: detail.message,
            });

            window.setTimeout(() => this.dismissToast(id), 2800);
        },
        dismissToast(id) {
            this.toasts = this.toasts.filter((toast) => toast.id !== id);
        },
        openPalette() {
            this.paletteOpen = true;
            this.$nextTick(() => this.$refs.paletteInput?.focus());
        },
        closePalette() {
            this.paletteOpen = false;
            this.paletteQuery = '';
        },
        handleEscape() {
            if (this.paletteOpen) {
                this.closePalette();

                return;
            }

            if (this.helpOpen) {
                this.helpOpen = false;

                return;
            }

            this.$dispatch('close-confirm-modal');
        },
        runPaletteAction(actionId) {
            if (actionId === 'run') {
                this.$dispatch('run-command');
            }

            if (actionId === 'clear') {
                this.$dispatch('clear-console-shortcut');
            }

            if (actionId === 'focus-snippets') {
                this.leftCollapsed = false;
                this.$nextTick(() => window.dispatchEvent(new CustomEvent('focus-snippet-search')));
            }

            if (actionId === 'focus-history') {
                this.rightCollapsed = false;
                this.$nextTick(() => window.dispatchEvent(new CustomEvent('focus-history-search')));
            }

            if (actionId === 'toggle-help') {
                this.helpOpen = !this.helpOpen;
            }

            this.closePalette();
        },
        applySafety(setting) {
            this.$dispatch('safety-setting-changed', { setting, value: this[setting] });
        },
        async copyToClipboard(detail = {}) {
            if (!detail.text) {
                return;
            }

            try {
                await navigator.clipboard.writeText(detail.text);
                this.pushToast({ type: 'success', message: 'Copied to clipboard.' });
            } catch (error) {
                this.pushToast({ type: 'error', message: 'Clipboard copy failed.' });
            }
        },
    }));

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
