function resolveCsrfToken() {
    return document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content') || '';
}

function toUpperMethod(method) {
    return String(method || 'GET').toUpperCase();
}

window.uiDispatchEvent = function uiDispatchEvent(eventName, detail = {}) {
    if (!eventName) {
        return;
    }

    window.dispatchEvent(new CustomEvent(eventName, { detail }));
};

window.uiSubmitAction = function uiSubmitAction(action = {}) {
    const href = action.href || action.url || '';
    const method = toUpperMethod(action.method);

    if (!href) {
        return;
    }

    if (method === 'GET') {
        window.location.href = href;
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = href;
    form.style.display = 'none';

    const csrfToken = resolveCsrfToken();
    if (csrfToken) {
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);
    }

    if (method !== 'POST') {
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = method;
        form.appendChild(methodInput);
    }

    document.body.appendChild(form);
    form.submit();
};

window.uiActionsDropdown = function uiActionsDropdown(config = {}) {
    return {
        id: config.id || `actions-${Math.random().toString(36).slice(2, 10)}`,
        actions: Array.isArray(config.actions) ? config.actions : [],
        normalizedActions: [],
        isOpen: false,
        menuId: '',
        menuLeft: 0,
        menuTop: 0,
        activeIndex: -1,
        closeOnViewportChange: null,
        init() {
            this.menuId = `${this.id}-menu`;
            this.normalizedActions = this.actions.map((action, index) =>
                this.normalizeAction(action, index),
            );

            this.closeOnViewportChange = () => this.closeMenu(false);
            window.addEventListener('resize', this.closeOnViewportChange);
            window.addEventListener('scroll', this.closeOnViewportChange, true);
        },
        destroy() {
            if (this.closeOnViewportChange) {
                window.removeEventListener('resize', this.closeOnViewportChange);
                window.removeEventListener(
                    'scroll',
                    this.closeOnViewportChange,
                    true,
                );
            }
        },
        normalizeAction(action, index) {
            const item = action && typeof action === 'object' ? action : {};
            const method = toUpperMethod(item.method);

            return {
                key: `${this.id}-${index}`,
                label: item.label || `Acción ${index + 1}`,
                href: item.href || null,
                method,
                variant: item.variant || 'default',
                confirm: Boolean(item.confirm),
                confirmTitle: item.confirmTitle || null,
                confirmMessage: item.confirmMessage || null,
                confirmButtonText: item.confirmButtonText || null,
                eventName: item.eventName || null,
                eventDetail:
                    item.eventDetail && typeof item.eventDetail === 'object'
                        ? item.eventDetail
                        : {},
                disabled: Boolean(item.disabled),
                disabledReason: item.disabledReason || '',
            };
        },
        hasActions() {
            return this.normalizedActions.length > 0;
        },
        triggerTitle() {
            if (!this.hasActions()) {
                return 'Sin acciones disponibles';
            }

            return 'Abrir menú de acciones';
        },
        menuStyle() {
            return `left:${this.menuLeft}px;top:${this.menuTop}px;`;
        },
        toggleMenu() {
            if (this.isOpen) {
                this.closeMenu();
                return;
            }

            this.openMenu();
        },
        openMenu() {
            if (!this.hasActions()) {
                return;
            }

            this.isOpen = true;
            this.$nextTick(() => {
                this.positionMenu();
                this.focusFirst();
            });
        },
        closeMenu(restoreFocus = true) {
            this.isOpen = false;
            this.activeIndex = -1;

            if (restoreFocus && this.$refs.trigger) {
                this.$refs.trigger.focus();
            }
        },
        handleTriggerKeydown(event) {
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                this.openMenu();
            }
        },
        handleMenuKeydown(event) {
            if (event.key === 'Escape') {
                event.preventDefault();
                this.closeMenu();
                return;
            }

            if (event.key === 'ArrowDown') {
                event.preventDefault();
                this.focusNext();
                return;
            }

            if (event.key === 'ArrowUp') {
                event.preventDefault();
                this.focusPrevious();
                return;
            }

            if (event.key === 'Home') {
                event.preventDefault();
                this.focusFirst();
                return;
            }

            if (event.key === 'End') {
                event.preventDefault();
                this.focusLast();
            }
        },
        getFocusableItems() {
            if (!this.$refs.menu) {
                return [];
            }

            return Array.from(
                this.$refs.menu.querySelectorAll(
                    '[data-menu-item]:not([disabled])',
                ),
            );
        },
        focusItem(index) {
            const items = this.getFocusableItems();
            if (!items.length) {
                this.activeIndex = -1;
                return;
            }

            const safeIndex = Math.max(0, Math.min(index, items.length - 1));
            this.activeIndex = safeIndex;
            items[safeIndex].focus();
        },
        focusFirst() {
            this.focusItem(0);
        },
        focusLast() {
            const items = this.getFocusableItems();
            this.focusItem(items.length - 1);
        },
        focusNext() {
            const items = this.getFocusableItems();
            if (!items.length) {
                return;
            }

            const nextIndex =
                this.activeIndex < 0
                    ? 0
                    : (this.activeIndex + 1) % items.length;
            this.focusItem(nextIndex);
        },
        focusPrevious() {
            const items = this.getFocusableItems();
            if (!items.length) {
                return;
            }

            const nextIndex =
                this.activeIndex <= 0
                    ? items.length - 1
                    : this.activeIndex - 1;
            this.focusItem(nextIndex);
        },
        positionMenu() {
            if (!this.$refs.trigger || !this.$refs.menu) {
                return;
            }

            const triggerRect = this.$refs.trigger.getBoundingClientRect();
            const menuRect = this.$refs.menu.getBoundingClientRect();
            const margin = 8;
            const viewportPadding = 12;

            let left = triggerRect.right - menuRect.width;
            let top = triggerRect.bottom + margin;

            if (left < viewportPadding) {
                left = viewportPadding;
            }

            if (left + menuRect.width > window.innerWidth - viewportPadding) {
                left = Math.max(
                    viewportPadding,
                    window.innerWidth - menuRect.width - viewportPadding,
                );
            }

            if (top + menuRect.height > window.innerHeight - viewportPadding) {
                top = Math.max(
                    viewportPadding,
                    triggerRect.top - menuRect.height - margin,
                );
            }

            this.menuLeft = Math.round(left);
            this.menuTop = Math.round(top);
        },
        actionClass(action) {
            const base =
                'w-full flex items-center gap-2 px-3 py-2 text-sm text-left transition rounded-lg';

            if (action.disabled) {
                return `${base} text-slate-400 cursor-not-allowed`;
            }

            switch (action.variant) {
                case 'danger':
                    return `${base} text-red-700 hover:bg-red-50`;
                case 'success':
                    return `${base} text-emerald-700 hover:bg-emerald-50`;
                case 'warning':
                    return `${base} text-amber-700 hover:bg-amber-50`;
                case 'info':
                    return `${base} text-sky-700 hover:bg-sky-50`;
                default:
                    return `${base} text-slate-700 hover:bg-slate-50`;
            }
        },
        runAction(action) {
            if (!action || action.disabled) {
                if (action?.disabledReason) {
                    window.uiDispatchEvent('ui:toast', {
                        type: 'warning',
                        message: action.disabledReason,
                    });
                }

                this.closeMenu();
                return;
            }

            if (action.confirm) {
                window.uiDispatchEvent('ui:confirm-modal.open', {
                    title: action.confirmTitle || 'Confirmar acción',
                    message:
                        action.confirmMessage ||
                        '¿Deseas continuar con esta acción?',
                    confirmButtonText: action.confirmButtonText || 'Confirmar',
                    confirmVariant:
                        action.variant === 'danger' ? 'danger' : 'default',
                    action: {
                        href: action.href,
                        method: action.method,
                        eventName: action.eventName,
                        eventDetail: action.eventDetail,
                    },
                });

                this.closeMenu();
                return;
            }

            this.executeAction(action);
            this.closeMenu();
        },
        executeAction(action) {
            if (action.eventName) {
                window.uiDispatchEvent(action.eventName, action.eventDetail);
            }

            if (action.href) {
                window.uiSubmitAction({
                    href: action.href,
                    method: action.method,
                });
            }
        },
    };
};

window.uiConfirmModal = function uiConfirmModal(config = {}) {
    return {
        isOpen: false,
        modalId: config.modalId || 'global-confirm-modal',
        defaultTitle: config.title || 'Confirmar acción',
        defaultMessage:
            config.message || '¿Deseas continuar con esta operación?',
        defaultConfirmText: config.confirmButtonText || 'Confirmar',
        defaultFormId: config.formId || null,
        title: config.title || 'Confirmar acción',
        message: config.message || '¿Deseas continuar con esta operación?',
        confirmButtonText: config.confirmButtonText || 'Confirmar',
        cancelButtonText: 'Cancelar',
        hideCancel: false,
        confirmVariant: 'default',
        pendingAction: null,
        pendingFormId: null,
        pendingEvent: null,
        triggerElement: null,
        openListener: null,
        init() {
            this.openListener = (event) => this.openFromEvent(event.detail || {});
            window.addEventListener('ui:confirm-modal.open', this.openListener);
        },
        destroy() {
            if (this.openListener) {
                window.removeEventListener(
                    'ui:confirm-modal.open',
                    this.openListener,
                );
            }
        },
        openFromEvent(detail) {
            this.title = detail.title || this.defaultTitle;
            this.message = detail.message || this.defaultMessage;
            this.confirmButtonText =
                detail.confirmButtonText || this.defaultConfirmText;
            this.cancelButtonText = detail.cancelButtonText || 'Cancelar';
            this.hideCancel = Boolean(detail.hideCancel);
            this.confirmVariant = detail.confirmVariant || 'default';
            this.pendingFormId = detail.formId || this.defaultFormId;
            this.pendingEvent = detail.eventName
                ? {
                      name: detail.eventName,
                      detail:
                          detail.eventDetail &&
                          typeof detail.eventDetail === 'object'
                              ? detail.eventDetail
                              : {},
                  }
                : null;
            this.pendingAction = detail.action
                ? {
                      href: detail.action.href || null,
                      method: toUpperMethod(detail.action.method),
                      eventName: detail.action.eventName || null,
                      eventDetail:
                          detail.action.eventDetail &&
                          typeof detail.action.eventDetail === 'object'
                              ? detail.action.eventDetail
                              : {},
                  }
                : detail.formAction
                  ? {
                        href: detail.formAction,
                        method: toUpperMethod(detail.formMethod || 'POST'),
                        eventName: null,
                        eventDetail: {},
                    }
                  : null;

            this.triggerElement = document.activeElement;
            this.isOpen = true;

            this.$nextTick(() => {
                this.focusPrimaryAction();
            });
        },
        close() {
            this.isOpen = false;
            this.pendingAction = null;
            this.pendingFormId = null;
            this.pendingEvent = null;

            if (this.triggerElement && typeof this.triggerElement.focus === 'function') {
                this.triggerElement.focus();
            }
        },
        focusPrimaryAction() {
            if (this.$refs.confirmButton) {
                this.$refs.confirmButton.focus();
            }
        },
        getFocusableElements() {
            if (!this.$refs.dialog) {
                return [];
            }

            return Array.from(
                this.$refs.dialog.querySelectorAll(
                    'a[href], button:not([disabled]), textarea, input, select, [tabindex]:not([tabindex="-1"])',
                ),
            ).filter((element) => !element.hasAttribute('hidden'));
        },
        handleDialogKeydown(event) {
            if (event.key === 'Escape') {
                event.preventDefault();
                this.close();
                return;
            }

            if (event.key !== 'Tab') {
                return;
            }

            const focusables = this.getFocusableElements();
            if (focusables.length === 0) {
                event.preventDefault();
                return;
            }

            const first = focusables[0];
            const last = focusables[focusables.length - 1];

            if (event.shiftKey) {
                if (document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                }
                return;
            }

            if (document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        },
        confirmButtonClass() {
            const base =
                'inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium transition';

            if (this.confirmVariant === 'danger') {
                return `${base} bg-red-600 text-white hover:bg-red-500`;
            }

            return `${base} bg-emerald-500 text-white hover:bg-emerald-400`;
        },
        confirm() {
            if (this.pendingAction) {
                if (this.pendingAction.eventName) {
                    window.uiDispatchEvent(
                        this.pendingAction.eventName,
                        this.pendingAction.eventDetail,
                    );
                }

                if (this.pendingAction.href) {
                    window.uiSubmitAction({
                        href: this.pendingAction.href,
                        method: this.pendingAction.method,
                    });
                }

                this.close();
                return;
            }

            if (this.pendingFormId) {
                const form = document.getElementById(this.pendingFormId);
                if (form) {
                    form.submit();
                }
                this.close();
                return;
            }

            if (this.pendingEvent) {
                window.uiDispatchEvent(
                    this.pendingEvent.name,
                    this.pendingEvent.detail,
                );
            }

            this.close();
        },
    };
};

window.uiToastStack = function uiToastStack(config = {}) {
    return {
        toasts: [],
        nextId: 1,
        listener: null,
        init() {
            const initial = Array.isArray(config.initialToasts)
                ? config.initialToasts
                : [];

            initial.forEach((toast) => this.pushToast(toast));

            this.listener = (event) => {
                this.pushToast(event.detail || {});
            };

            window.addEventListener('ui:toast', this.listener);
        },
        destroy() {
            if (this.listener) {
                window.removeEventListener('ui:toast', this.listener);
            }
        },
        pushToast(payload = {}) {
            const message = String(payload.message || '').trim();
            if (!message) {
                return;
            }

            const toast = {
                id: this.nextId++,
                message,
                type: payload.type || 'info',
                duration:
                    Number.isInteger(payload.duration) && payload.duration > 0
                        ? payload.duration
                        : 4500,
            };

            this.toasts.push(toast);
            this.scheduleDismiss(toast.id, toast.duration);
        },
        scheduleDismiss(id, duration) {
            window.setTimeout(() => {
                this.dismiss(id);
            }, duration);
        },
        dismiss(id) {
            this.toasts = this.toasts.filter((toast) => toast.id !== id);
        },
        toastClass(toast) {
            const base =
                'pointer-events-auto w-full sm:w-96 rounded-xl border px-4 py-3 shadow-lg backdrop-blur-sm';

            switch (toast.type) {
                case 'success':
                    return `${base} border-emerald-200 bg-emerald-50 text-emerald-800`;
                case 'error':
                    return `${base} border-red-200 bg-red-50 text-red-800`;
                case 'warning':
                    return `${base} border-amber-200 bg-amber-50 text-amber-800`;
                default:
                    return `${base} border-sky-200 bg-sky-50 text-sky-800`;
            }
        },
    };
};

window.uiUnitWasteActionModals = function uiUnitWasteActionModals() {
    return {
        showRegister: false,
        showView: false,
        unitName: '',
        registerUrls: {
            resol: '',
            respel: '',
        },
        viewUrls: {
            resol: '',
            respel: '',
        },
        registerListener: null,
        viewListener: null,
        init() {
            this.registerListener = (event) => {
                const detail = event.detail || {};
                this.unitName = detail.unitName || '';
                this.registerUrls.resol = detail.resolCreateUrl || '';
                this.registerUrls.respel = detail.respelCreateUrl || '';
                this.showView = false;
                this.showRegister = true;
            };

            this.viewListener = (event) => {
                const detail = event.detail || {};
                this.unitName = detail.unitName || '';
                this.viewUrls.resol = detail.resolUrl || '';
                this.viewUrls.respel = detail.respelUrl || '';
                this.showRegister = false;
                this.showView = true;
            };

            window.addEventListener(
                'wastes:unit-register-modal.open',
                this.registerListener,
            );
            window.addEventListener(
                'wastes:unit-view-modal.open',
                this.viewListener,
            );
        },
        destroy() {
            if (this.registerListener) {
                window.removeEventListener(
                    'wastes:unit-register-modal.open',
                    this.registerListener,
                );
            }

            if (this.viewListener) {
                window.removeEventListener(
                    'wastes:unit-view-modal.open',
                    this.viewListener,
                );
            }
        },
        goTo(url) {
            if (!url) {
                return;
            }

            window.location.href = url;
        },
    };
};
