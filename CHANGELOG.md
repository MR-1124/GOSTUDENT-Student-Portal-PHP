# Changelog

All notable changes to the GOSTUDENT project.

## [2.1.0] - 2024-12-13

### Added
- **Collapsible Side Navbar** with smooth animations (280px ↔ 80px)
  - Toggle button at bottom, state persistence, tooltips in collapsed mode
  - Active page indicator with gradient bar
- **Redesigned Login/Signup Pages** with glassmorphic design
  - Animated gradient backgrounds, icon-enhanced inputs
  - Interactive role selection cards, dedicated auth.css
- **Notice Card Component** with proper image sizing (200px)
  - Hover zoom effect, text clamp, organized metadata footer
- **New Dashboard Components**
  - Welcome banner, stats grid, page headers, empty states, loading spinner
- **Sample Data Files** in database folder
  - sample_data.sql (with users), quick_sample_data.sql, verify_data.sql

### Changed
- **Navigation** from top bar to fixed side navbar
- **Card Components** with gradient accent bars and better spacing
- **Footer** updated for project context with GitHub link
- **Main Content Area** adjusted for sidebar with dynamic margins

### Fixed
- **Header Warning** - "Cannot modify header information - headers already sent" (8 files)
- **File Upload Issues** - Enhanced uploadFile() with multi-type support
  - Documents: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, ZIP (10MB max)
  - Images: JPEG, PNG, GIF, WEBP (5MB max)
- **Notice Images** - Corrected paths and sizing

### Technical
- Enhanced uploadFile() function with type parameter ('image', 'document', 'all')
- Moved POST handling before header includes to prevent redirect errors
- Added MIME type validation and better error messages
- Organized SQL files in database/ folder
- Cleaned up 14 temporary documentation files

---

## [2.0.0] - 2025-08-12

### Added
- **Apple-inspired Design System** with shadcn principles
- **CSS Theme File** - assets/css/apple-theme.css (800+ lines)
- **Design Tokens** - 15+ CSS variables for colors, spacing, typography
- **Component Library** - 20+ reusable UI components
- **Dark Mode** - Automatic support via prefers-color-scheme
- **SVG Icons** - Inline SVG replacing Material Icons
- **Modal System** - Custom implementation with backdrop blur
- **Badge System** - 5 color variants
- **Avatar Component** - With gradient fallback

### Changed
- **Navigation** - Glassmorphic navbar with backdrop blur
- **All Pages** - 21 pages redesigned with new system
- **Typography** - SF Pro-inspired font stack
- **Color Scheme** - Apple blue palette (#667eea, #764ba2)
- **Buttons** - 5 variants (primary, secondary, destructive, outline, ghost)
- **Forms** - Modern inputs with focus states
- **Cards** - Subtle shadows with hover effects

### Removed
- **Materialize CSS** - Complete framework removal
- **Material Icons** - Replaced with SVG
- **Google Fonts** - Using system fonts
- **jQuery** - No longer needed
- **External CDN Dependencies** - All self-contained

### Performance
- 75% reduction in CSS file size (200KB → 50KB)
- Faster load times (no CDN requests)
- Optimized animations (GPU-accelerated)
- Single CSS file for better caching

### Accessibility
- WCAG AA compliant color contrasts
- Full keyboard navigation support
- Screen reader optimized markup
- Better focus states

---

## [1.0.0] - Previous Version

### Initial Release
- Basic GOSTUDENT functionality
- Materialize CSS framework
- Material Design aesthetic
- Student and teacher dashboards
- Assignment and quiz management
- Notice board system
- Doubt resolution system
- Grade management

---

**Format**: Based on [Keep a Changelog](https://keepachangelog.com/)  
**Versioning**: [Semantic Versioning](https://semver.org/)
