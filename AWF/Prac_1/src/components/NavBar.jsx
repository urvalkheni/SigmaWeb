import React from 'react';

const NavBar = ({ activeTab, setActiveTab }) => {
  const navItems = ['About', 'Skills', 'Projects'];

  return (
    <nav className="navbar glass-panel animate-fade-in" style={{ padding: '1rem', borderRadius: '50px' }}>
      {navItems.map((item) => (
        <div 
          key={item}
          className={`nav-link ${activeTab === item ? 'active' : ''}`}
          onClick={() => setActiveTab(item)}
        >
          {item}
        </div>
      ))}
    </nav>
  );
};

export default NavBar;
