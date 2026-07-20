import React from 'react';
// No icons imported

const Footer = () => {
  return (
    <footer>
      <p>© {new Date().getFullYear()} Urval Kheni. All rights reserved.</p>
      <div className="social-links">
        <a href="https://github.com/urvalkheni" target="_blank" rel="noreferrer" style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
          GitHub
        </a>
        <a href="https://gitlab.com/urvalkheni" target="_blank" rel="noreferrer" style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
          GitLab
        </a>
        <a href="https://www.linkedin.com/in/urval-kheni" target="_blank" rel="noreferrer" style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
          LinkedIn
        </a>
      </div>
    </footer>
  );
};

export default Footer;
