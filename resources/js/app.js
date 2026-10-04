import { createIcons, ArrowUpRight, ChevronLeft, Globe, LogOut, Mail, MapPin, Newspaper, Phone, User, UtensilsCrossed } from 'lucide';

createIcons({ icons: { ArrowUpRight, ChevronLeft, Globe, LogOut, Mail, MapPin, Newspaper, Phone, User, UtensilsCrossed } });

const sidebar = document.querySelector('[data-sidebar]');
const sidebarToggle = document.querySelector('[data-sidebar-toggle]');

if (sidebar && sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('w-60');
        sidebar.classList.toggle('w-20');
        sidebarToggle.classList.toggle('rotate-180');

        sidebar.querySelectorAll('[data-sidebar-label]').forEach((label) => {
            label.classList.toggle('sr-only');
        });

        sidebarToggle.setAttribute('aria-expanded', sidebar.classList.contains('w-60'));
    });
}
