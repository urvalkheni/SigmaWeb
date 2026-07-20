import React from 'react';

const Skills = ({ skillList }) => {
  return (
    <section className="glass-panel animate-fade-in">
      <h2 className="section-title">My Skills</h2>
      <ul className="skills-list">
        {skillList.map((skill) => (
          <li key={skill} className="skill-item">
            {skill}
          </li>
        ))}
      </ul>
    </section>
  );
};

export default Skills;
