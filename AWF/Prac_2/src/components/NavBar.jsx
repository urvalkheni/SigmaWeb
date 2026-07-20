import React from 'react';
import { NavLink } from 'react-router-dom';

const NavBar = () => {
  return (
    <nav className="navbar glass-panel animate-fade-in" style={{ padding: '1rem', borderRadius: '50px' }}>
      <NavLink 
        to="/" 
        className={({ isActive }) => `nav-link ${isActive ? 'active' : ''}`}
        end
      >
        Home
      </NavLink>
      <NavLink 
        to="/projects" 
        className={({ isActive }) => `nav-link ${isActive ? 'active' : ''}`}
      >
        Projects
      </NavLink>
      <NavLink 
        to="/contact" 
        className={({ isActive }) => `nav-link ${isActive ? 'active' : ''}`}
      >
        Contact
      </NavLink>
    </nav>
  );
};

export default NavBar;
