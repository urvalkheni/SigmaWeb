import React from 'react';

const Header = ({ name, themeColor }) => {
  return (
    <header className="header-container animate-fade-in">
      <h1 className="header-title" style={{ color: themeColor }}>
        {name}
      </h1>
      <p>Student Developer Portfolio</p>
    </header>
  );
};

export default Header;
