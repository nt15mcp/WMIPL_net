# Software Design Document

## 1. Introduction

### 1.1 Purpose

The purpose of the Shooting League Management System is to create an efficient and user-friendly web application that caters to the specific needs of shooting leagues. The system aims to automate league administration tasks, provide comprehensive statistical insights, and foster communication between league administrators and members. By offering a centralized platform, it strives to enhance the overall experience for both league organizers and participants.

### 1.2 Scope

#### 1.2.1 Inclusions

The application will encompass the following key features:

- **Super Login:** A secure portal for league administrators to manage league details, including schedules, teams, divisions, and communications, without the need for programming skills.

- **User Login:** A personalized space for league members to register for seasons, view upcoming match schedules, access match results, analyze historical trends, and receive league communications.

- **Statistician Login:** A specialized login for statisticians to enter and adjust shooter scores, perform calculations for individual and team results, and contribute to the statistical analysis of the league.

- **Communication Platform:** The application will serve as a communication hub, facilitating seamless interaction between league administrators and members.

#### 1.2.2 Exclusions

The application will not handle at this time:

- **Financial Transactions:** The system will not process financial transactions such as league fees or prize distribution. Financial aspects will be managed through external means.

- **Live Match Streaming:** Real-time match streaming and live updates will not be part of this version.

#### 1.2.3 Future Enhancements

The system is designed with scalability in mind, allowing for future enhancements such as:

- **Additional Statistical Analysis:** Integrate advanced statistical models to provide deeper insights into shooter performance and trends.

- **Expanded Communication Features:** Incorporate features like forums or live chat for enhanced communication among league members.

- **Integration with External Platforms:** Explore opportunities to integrate with external platforms for wider exposure and collaboration.

### 1.3 Objectives

The primary objectives of the Shooting League Management System include:

- **Efficiency:** Streamline league administration processes to reduce manual efforts and improve efficiency.

- **User Engagement:** Provide league members with a compelling and informative platform for active participation and engagement.

- **Accuracy in Results:** Ensure accurate recording and calculation of shooter scores and league results.

- **Scalability:** Design the system to handle potential increases in the number of shooters, teams, and divisions.

By meeting these objectives, the application aims to become the go-to platform for shooting leagues seeking effective management and enhanced member experiences.

## 2. User Stories and Use Cases

### 2.1 User

#### 2.1.1 View Upcoming Match Schedules

- **Description:** As a user, I want to be able to view a clear and detailed schedule of upcoming matches to plan my participation effectively.
  
- **Acceptance Criteria:**
  - The schedule should include date, time, location, and opposing teams.
  - Users should be able to filter the schedule based on specific criteria (e.g., team, division, date range).
  - The schedule should be presented in a user-friendly and responsive manner for easy access on different devices.

#### 2.1.2 Access and Review Personal Match Results

- **Description:** As a user, I want the ability to access and review detailed information about my individual match results to track my performance over time.
  
- **Acceptance Criteria:**
  - Users should have a dedicated space or dashboard where they can access their match results.
  - The results should include scores, statistics, and any relevant commentary or notes.
  - Historical results should be archived and easily accessible for reference.

#### 2.1.3 Compare Results with Historical Data and Other Shooters

- **Description:** As a user, I want to compare my current and historical results with other shooters in the league for benchmarking and friendly competition.
  
- **Acceptance Criteria:**
  - A comparative analysis feature should be available, allowing users to see their performance trends.
  - Users should be able to compare their scores with averages, top performers, and specific individuals.
  - Visualizations, such as charts or graphs, should be provided to enhance the understanding of comparative data.

### 2.2 League Administrator

#### 2.2.1 Communicate with League Members Efficiently

- **Description:** As a league administrator, I want efficient tools to communicate important information, updates, and announcements to all league members.
  
- **Acceptance Criteria:**
  - An announcement or messaging system should be available for sending messages to all league members.
  - Administrators should be able to categorize messages for different purposes (e.g., general announcements, urgent notices, upcoming events).
  - Members should receive notifications through email or in-app alerts.

#### 2.2.2 Manage League Details Without Programming Skills

- **Description:** As a league administrator, I want a user-friendly interface that allows me to manage league details, including schedules, teams, and divisions, without requiring programming skills.
  
- **Acceptance Criteria:**
  - An intuitive dashboard should provide options for managing schedules, teams, and divisions.
  - Actions such as adding, editing, or removing teams should be straightforward.
  - Changes made by administrators should be reflected instantly on the website.

#### 2.2.3 Maintain Schedules, Teams, and Divisions Effortlessly

- **Description:** As a league administrator, I want to effortlessly maintain and update league schedules, teams, and divisions to ensure accurate and timely information for all league members.
  
- **Acceptance Criteria:**
  - A centralized management system should allow administrators to modify schedules, add or remove teams, and adjust divisions.
  - Changes should trigger notifications to affected users.
  - The system should handle conflicts, such as rescheduling or team reassignments, seamlessly.

### 2.3 Statistician

#### 2.3.1 Enter and Adjust Shooter Scores Accurately

- **Description:** As a statistician, I want a reliable interface to enter and adjust shooter scores accurately to ensure the integrity of statistical data.
  
- **Acceptance Criteria:**
  - The system should provide a dedicated portal for entering scores with fields for each shooter and match.
  - Validation checks should be in place to prevent erroneous data entry.
  - Statisticians should be able to make adjustments or corrections with proper audit trails.

#### 2.3.2 Perform Calculations for Individual and Team Results Efficiently

- **Description:** As a statistician, I want efficient tools to perform calculations for individual and team results, enabling timely updates and analysis.
  
- **Acceptance Criteria:**
  - The system should automatically calculate individual scores based on entered data.
  - Team scores, averages, and other relevant statistics should be updated in real-time.
  - Statistical summaries and reports should be generated with ease.

# Software Design Document

## 3. Functional Requirements

### 3.1 User Management

#### 3.1.1 User Registration and Authentication

- **Description:** The system should provide a secure and user-friendly mechanism for individuals to register and authenticate themselves.

- **Acceptance Criteria:**
  - Users should be able to create an account with a unique username and password.
  - Account authentication should be performed securely, using industry-standard protocols.
  - Passwords should be securely stored using hashing techniques.

#### 3.1.2 Storage of User Data

- **Description:** The system should store and manage user data, including login information, shooter scores, personal contact details, and user preferences.

- **Acceptance Criteria:**
  - User data should be stored securely in a database.
  - Data should be appropriately normalized and indexed for efficient retrieval.
  - User preferences should include customizable settings for a personalized user experience.

### 3.2 Data Management

#### 3.2.1 Retrieval of Match Data

- **Description:** The system should retrieve relevant data for displaying match schedules, results, and historical trends.

- **Acceptance Criteria:**
  - Data retrieval should be efficient, providing real-time or near-real-time updates.
  - Match schedules should include details such as date, time, location, and participating teams.
  - Historical trends should be accessible for analysis.

#### 3.2.2 Display of Data on Website Pages

- **Description:** The system should display data on various website pages, including about, contact, schedule, roster, scores, and leader board.

- **Acceptance Criteria:**
  - Each page should present data in a clear and visually appealing format.
  - Pages should be responsive and compatible with different devices.
  - Navigation between pages should be intuitive and user-friendly.

### 3.3 Result Calculations

#### 3.3.1 Calculation of Results

- **Description:** The system should perform calculations for individual and team results, including team performance metrics.

- **Acceptance Criteria:**
  - Individual results should be calculated based on entered scores and other relevant data.
  - Team performance should be calculated considering individual scores, team composition, and any specified metrics.
  - Results should be updated in real-time.

### 3.4 Communication

#### 3.4.1 Email Distribution Notifications

- **Description:** The system should have the capability to send email notifications to league members for important announcements, updates, or relevant information.

- **Acceptance Criteria:**
  - League administrators should have a user-friendly interface for composing and sending email notifications.
  - Members should receive notifications promptly and reliably.

### 3.5 Mobile Interaction

#### 3.5.1 Mobile-Friendly Interactions

- **Description:** The system should provide mobile-friendly interactions to ensure a seamless user experience on various devices.

- **Acceptance Criteria:**
  - All website pages should be accessible and functional on mobile devices.
  - User interactions, such as navigation and data input, should be optimized for mobile use.
  - Responsive design principles should be applied to enhance usability.

# Software Design Document

## 4. Non-functional Requirements

### 4.1 Security

#### 4.1.1 Adherence to Current Web Security Standards

- **Description:** The system must adhere to the latest web security standards to ensure robust protection against potential vulnerabilities and attacks.

- **Acceptance Criteria:**
  - Regular security audits should be conducted to identify and address any security vulnerabilities.
  - The system should comply with best practices for secure coding and data protection.

#### 4.1.2 Encryption and Secure Storage of Personally Identifiable Information (PPI)

- **Description:** Personally identifiable information (PPI) should be encrypted during transmission and securely stored in the database to safeguard user privacy.

- **Acceptance Criteria:**
  - All data transmissions, especially involving PPI, should use secure encryption protocols (e.g., HTTPS).
  - PPI stored in the database should be encrypted using industry-standard encryption algorithms.

### 4.2 Performance

#### 4.2.1 System Performance within Reasonable Limits

- **Description:** The system should demonstrate satisfactory performance within acceptable response times and resource consumption.

- **Acceptance Criteria:**
  - Page loading times should be within acceptable limits, even under peak usage conditions.
  - Database queries and transactions should be optimized for efficiency.
  - Resource usage (CPU, memory, bandwidth) should remain within reasonable limits.

### 4.3 Scalability

#### 4.3.1 System Scalability for Future League Adjustments

- **Description:** The system should be designed to handle potential increases in league size, team numbers, and other adjustments without compromising performance.

- **Acceptance Criteria:**
  - The architecture should support horizontal scalability, allowing for easy addition of servers or resources.
  - Database design should accommodate an increase in data volume without degradation in performance.
  - Codebase and infrastructure should be modular to facilitate scalability adjustments.

## 5. Architecture

### 5.1 System Architecture

- **Description:** The application will follow a client-server architecture, utilizing MySQL for database management, PHP for server-side scripting, and HTML/CSS for the frontend.

- **Acceptance Criteria:**
  - The client-side (frontend) should be developed using HTML for markup and CSS for styling to ensure a responsive and visually appealing user interface.
  - The server-side (backend) should be implemented using PHP for server-side scripting to handle user requests, process data, and interact with the database.
  - The database management system (DBMS) will be MySQL, providing a robust and relational data storage solution.

## 6. Database Design

The database will include the following tables:

- **User login information**
  - Fields: user_id, username, password_hash, email, registration_date, last_login_date, etc.

- **Shooter scores**
  - Fields: score_id, user_id, match_id, score_value, date_submitted, etc.

- **User personal contact information**
  - Fields: user_id, first_name, last_name, address, phone_number, etc.

- **User preferences**
  - Fields: user_id, theme_preference, notification_settings, etc.

- **Website page content for static display pages**
  - Fields: page_id, page_title, content, last_updated, etc.

- **League schedule**
  - Fields: match_id, date, time, location, home_team, away_team, etc.

- **Team structure**
  - Fields: team_id, team_name, captain_id, league_id, etc.

- **Division structure**
  - Fields: division_id, division_name, league_id, etc.

- **Manual tie-breaker information**
  - Fields: tie_breaker_id, description, criteria, etc.

- **Shooter replacements**
  - Fields: replacement_id, original_shooter_id, replacement_shooter_id, match_id, reason, etc.

## 7. User Interface Design

### 7.1 Pages


- **Welcome/Home**
- **About**
- **Scores**
- **Leaderboard**
- **Roster**
- **Rules**
- **Schedule**
- **Contact**

### 7.2 Functionality

- **Login/logout functionality for users.**
  - Users should be able to log in securely, with the option to log out when desired.

- **Admin login for league administration.**
  - League administrators should have a secure login for managing league details.

## 8. Security Considerations

- **Page tracking through PHP super global variables.**
  - Utilize PHP super global variables securely to track and manage page access.

- **Sanitization and filtering of POST data.**
  - Implement proper sanitization and filtering techniques for data received via POST requests.

- **Encryption and secure storage of PPI.**
  - Personally identifiable information (PPI) should be encrypted during transmission and securely stored in the database.

- **Credential storage outside public folders with access restrictions via .htaccess.**
  - Store sensitive credentials in non-public directories and implement access restrictions using .htaccess.

## 9. Testing Strategy

- **Development and testing will be performed in a self-served environment by the webmaster/developer.**
  - The webmaster/developer will have a dedicated environment for development and testing, ensuring the stability and functionality of the application.

## 10. Deployment Plan

- **The application will be hosted on Hostinger.com and served through the secure Cloudflare service.**
  - Host the application on Hostinger.com for reliable hosting, and leverage Cloudflare for added security and performance benefits.

## 11. Maintenance and Support

- **The webmaster will be responsible for maintaining and supporting the website through any required changes.**
  - The designated webmaster will handle ongoing maintenance tasks and provide support for any necessary changes or updates.
