# Design System & Guidelines (International Swiss Style & shadcn/ui)

This project adopts a modern, premium frontend aesthetic inspired by the **International Swiss Style** and **shadcn/ui** design system baselines.

---

## 1. Core Typography

- **Primary Font**: `Inter` (weights: 400, 500, 600, 700).
- **Font Features**: We use advanced font-feature settings (`"cv02"`, `"cv03"`, `"cv04"`, `"cv11"`) for high legibility, clean sans-serif spacing, and precise numeral alignment.
- **Eyebrows & Headings**: Eyebrows use `font-semibold uppercase tracking-wider text-zinc-400` with smaller sizes (e.g. `text-[10px]`), while main headings use high-contrast sans-serif sizes (e.g. `text-2xl font-bold tracking-tight text-zinc-950`).

---

## 2. Color System & Contrast

We use a high-contrast, clean monochrome color palette based on Tailwind's **Zinc** color spectrum:
- **Background**: `#fafafa` (Zinc 50/50).
- **Text Primary**: `#09090b` (Zinc 950).
- **Text Secondary**: `#71717a` (Zinc 500) or `#52525b` (Zinc 600).
- **Borders**: `#e4e4e7` (Zinc 200) or `#f4f4f5` (Zinc 100).
- **Accents**: Subtle HSL pastel colors for badges (e.g., light emerald, amber, red).

---

## 3. UI Component Baselines

### Cards (`<x-card>`)
- Cards are styled as: `rounded-xl border border-zinc-200 bg-white p-6 shadow-sm`.
- **Nested Card Rule**: **Never nest a card (or card-like bordered container) inside another card.** If grouping details inside a card, use a borderless container with a flat background (e.g., `bg-zinc-50 rounded-lg p-4`) instead of drawing double borders/lines.

### Buttons (`<x-button>`)
Our buttons directly draw inspiration from the premium baseline of shadcn/ui:
- **Primary**: `bg-zinc-900 text-zinc-50 hover:bg-zinc-900/90 shadow rounded-md h-9 text-sm font-medium transition-colors`
- **Secondary**: `border-zinc-200 bg-white text-zinc-900 hover:bg-zinc-50 shadow-sm rounded-md h-9 text-sm font-medium transition-colors`
- **Danger**: `bg-red-600 text-white hover:bg-red-600/90 shadow-sm rounded-md h-9 text-sm font-medium transition-colors`

### Inputs, Selects, & Textareas
All form fields are styled uniformly using a global CSS apply rule in `resources/css/app.css` to keep HTML clean:
- **Base Style**: `rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 shadow-sm transition-all focus:border-zinc-900 focus:ring-1 focus:ring-zinc-900 focus:outline-none`.
- **Guideline**: Do **not** override input corners inline with `rounded-none`. Let them inherit `rounded-md` naturally. Ensure all text inputs specify the correct `type` attribute (e.g. `type="text"`, `type="email"`) so they are targeted correctly.

### Data Tables (`<x-table>`)
Tabular data must be clean and functional:
- **Outer Wrapper**: Subtle border and light shadow: `rounded-lg border border-zinc-200 bg-white shadow-sm`.
- **Headers (`<thead>`)**: Clean sans-serif style: `text-zinc-500 font-medium text-xs border-b border-zinc-200`. Do not use gray background blocks (`bg-gray-100`) or bold monospace tags.
- **Rows (`<tr>`)**: Smooth subtle hover states: `hover:bg-zinc-50/50 transition-colors`.

---

## 4. Maintenance Guidelines
- Ensure that any new views or modifications respect this typography and radius system.
- Always use the predefined `@theme` radius tokens (`rounded-md`, `rounded-xl`) and Zinc colors rather than custom values.
- Re-run `bun run build` after styling changes to check asset compilation and keep the build bundle optimized.
