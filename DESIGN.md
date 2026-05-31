# SurveyKita Design System

SurveyKita now uses a strict International Swiss Style interface with a shadcn/ui baseline adapted for flat academic product screens.

## Typography

- Use `Stack Sans Text` for body, labels, controls, and table text.
- Use `Stack Sans Headline` for page titles, section titles, and metric numbers.
- Layout files must keep the Bunny font link for both Stack Sans families.
- Avoid decorative uppercase mono labels. Prefer plain sentence-case labels in `text-sm` or `text-xs`.

## Geometry

- The interface is square by default. Radius tokens are set to `0` in Tailwind theme variables.
- Do not add rounded cards, rounded buttons, rounded inputs, or pill containers unless a semantic badge requires compact labeling.
- No shadows. Hierarchy comes from spacing, borders, grid position, and typographic scale.

## Surfaces

- Use `bg-zinc-50` for page canvas and `bg-white` for primary surfaces.
- Use `border-zinc-200` as the main structural line.
- Do not nest bordered cards inside bordered cards. Use flat internal grids with `gap-px`, `bg-zinc-200`, and white cells when detail grouping is needed.

## Components

### Buttons

- Primary: black background, white text, black border.
- Secondary: white background, black text, zinc border.
- Danger: red background, white text.
- Button text must stay on one line at desktop sizes.

### Forms

- Labels sit above fields.
- Inputs, selects, and textareas inherit global square border styling.
- Do not use placeholders as labels.

### Tables

- Tables are line-based: one outer border, a header bottom border, and row dividers.
- Headers use `text-zinc-500 font-medium text-xs`.
- Do not use colored table heads, nested cards in cells, shadows, or heavy uppercase mono headers.

## Maintenance Rules

- Preserve route names, field names, and Blade component contracts unless the backend is changed deliberately.
- New UI should start from shared components in `resources/views/components`.
- Rebuild assets with `bun run build` when you want to verify compiled CSS locally.
