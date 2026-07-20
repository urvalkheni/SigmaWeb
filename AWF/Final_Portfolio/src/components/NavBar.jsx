import React from 'react';
import { Shield, Mail } from 'lucide-react';

const NavBar = ({ themeMode, toggleTheme }) => {
  const links = ['About', 'Experience', 'Contributions', 'Projects', 'Skills', 'Certifications', 'Contact'];

  const scrollToSection = (id) => {
    const element = document.getElementById(id);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
  };

  return (
    <nav className="navbar-container glass-panel" style={{ padding: '0.75rem 2rem', marginBottom: '0' }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', color: 'var(--accent-color)', fontWeight: 'bold' }}>
        <Shield size={24} />
        <span>Urval.Sec</span>
      </div>
      
      <div className="nav-links">
        {links.map((link) => (
          <span 
            key={link} 
            className="nav-link"
            onClick={() => scrollToSection(link.toLowerCase())}
          >
            {link}
          </span>
        ))}
      </div>

      <button 
        onClick={toggleTheme}
        style={{
          padding: '0.5rem 1rem',
          borderRadius: '20px',
          border: '1px solid var(--border-color)',
          background: 'var(--card-bg)',
          color: 'var(--text-color)',
          cursor: 'pointer',
          fontWeight: 'bold',
          display: 'flex',
          alignItems: 'center',
          gap: '0.5rem'
        }}
      >
        {themeMode === 'dark' ? '☀️ Light' : '🌙 Dark'}
      </button>
    </nav>
  );
};

export default NavBar;
