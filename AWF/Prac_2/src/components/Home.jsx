import React from 'react';
import About from './About';
import Skills from './Skills';

const Home = () => {
  const mySkills = ['JavaScript', 'React', 'Node.js', 'CSS3', 'HTML5', 'Git', 'Python'];

  return (
    <div className="animate-fade-in">
      <About />
      <div style={{ marginTop: '2rem' }}></div>
      <Skills skillList={mySkills} />
    </div>
  );
};

export default Home;
