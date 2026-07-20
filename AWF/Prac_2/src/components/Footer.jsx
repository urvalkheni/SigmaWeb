import React from 'react';

const Footer = () => {
  return (
    <footer className="footer-container">
      <p>© {new Date().getFullYear()} Urval Kheni. All rights reserved.</p>
      <p>
        <a href="https://github.com/urvalkheni" target="_blank" rel="noreferrer">GitHub</a> | {' '}
        <a href="https://gitlab.com/urvalkheni" target="_blank" rel="noreferrer">GitLab</a> | {' '}
        <a href="https://www.linkedin.com/in/urval-kheni" target="_blank" rel="noreferrer">LinkedIn</a>
      </p>
    </footer>
  );
};

export default Footer;
