-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 04:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poly`
--

-- --------------------------------------------------------

--
-- Table structure for table `addorder`
--

CREATE TABLE `addorder` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `OrderDate` date NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Address` text NOT NULL,
  `Country` varchar(100) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Payment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addorder`
--

INSERT INTO `addorder` (`OrderID`, `ProductID`, `Email`, `OrderDate`, `Quantity`, `Address`, `Country`, `Amount`, `Payment`) VALUES
(1, 1, 'n@gmail.com', '2025-02-28', 50, '154', 'srilanka', 1250.00, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `credit_table`
--

CREATE TABLE `credit_table` (
  `CreditID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `CardNumber` varchar(16) NOT NULL,
  `ExpiryDate` varchar(7) NOT NULL,
  `CVV` varchar(4) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` datetime NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cusfeedback`
--

CREATE TABLE `cusfeedback` (
  `id` int(11) NOT NULL,
  `FeedbackType` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Discription` text DEFAULT NULL,
  `reply` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cusfeedback`
--

INSERT INTO `cusfeedback` (`id`, `FeedbackType`, `Name`, `Email`, `Discription`, `reply`) VALUES
(1, 'Complaint', 'Aliya Perera', 'aliya.perera@example.com', 'Received damaged polythene bags, not usable.', 'Apologies for the inconvenience, we will replace the items immediately.'),
(2, 'Normal Feedback', 'Lahiru Silva', 'lahiru.silva@example.com', 'Suggested using eco-friendly packaging for the products.', 'We are currently researching sustainable packaging options.'),
(3, 'Complaint', 'Nadeesha Jayasinghe', 'nadeesha.jayasinghe@example.com', 'Delivery was delayed by 3 days, which caused issues with our production schedule.', 'We sincerely apologize for the delay and will ensure timely deliveries in the future.'),
(4, 'Normal Feedback', 'Saman Wickramasinghe', 'saman.wickramasinghe@example.com', 'Great quality polythene rolls, very pleased with the product.', 'Thank you for your positive feedback! We appreciate your support.'),
(5, 'Complaint', 'Dinesh Fernando', 'dinesh.fernando@example.com', 'The shrink film was not up to the expected thickness.', 'We are reviewing this issue with the production team and will provide replacements.'),
(6, 'Complaint', 'Chandima Ratnayake', 'chandima.ratnayake@example.com', 'Received wrong size of polythene sheets, needs to be exchanged.', 'We apologize for the mistake and will arrange for an exchange as soon as possible.'),
(7, 'Normal Feedback', 'Tharindu Perera', 'tharindu.perera@example.com', 'Polythene bags could be improved in strength for better durability.', 'Thank you for your suggestion! We are working on enhancing the durability of our bags.'),
(8, 'Normal Feedback', 'Dilani Ruwanthi', 'dilani.ruwanthi@example.com', 'Fantastic customer service, very helpful during the ordering process.', 'We are thrilled to hear your feedback. Thank you for your kind words!'),
(9, 'Complaint', 'Pradeep Dissanayake', 'pradeep.dissanayake@example.com', 'The quantity delivered was less than ordered.', 'We regret the issue and will dispatch the missing quantity at no additional cost.'),
(10, 'Normal Feedback', 'Rashmi Kumari', 'rashmi.kumari@example.com', 'Impressed with the fast delivery, received the order earlier than expected.', 'Thank you for sharing your experience with us! We are glad to exceed your expectations.'),
(11, 'Complaint', 'Buddhi Rajapaksha', 'buddhi.rajapaksha@example.com', 'The bags had uneven edges and were difficult to use in our process.', 'We are addressing this with our manufacturing team for immediate improvement.'),
(12, 'Normal Feedback', 'Tharindu Gamage', 'tharindu.gamage@example.com', 'Requesting more color variety for polythene bags.', 'We are exploring the possibility of expanding our color range for future orders.'),
(13, 'Normal Feedback', 'Upeka Samarawickrama', 'upeka.samarawickrama@example.com', 'The packaging was done perfectly, no damages in transit.', 'We appreciate your feedback and are glad your products arrived safely.'),
(14, 'Complaint', 'Kumudu Kumari', 'kumudu.kumari@example.com', 'The shrink wrap didn’t adhere properly to the product.', 'We will investigate this issue and provide a solution at the earliest.'),
(15, 'Normal Feedback', 'Shanika Rathnayake', 'shanika.rathnayake@example.com', 'Suggest providing bulk purchase discounts for regular customers.', 'Thank you for your suggestion. We are considering options for bulk discounts in the future.'),
(16, 'Normal Feedback', 'Manoj Weerasinghe', 'manoj.weerasinghe@example.com', 'The product quality was consistent, just as expected.', 'Thank you for your continued trust in our products!'),
(17, 'Complaint', 'Jayantha Nimal', 'jayantha.nimal@example.com', 'Packaging was torn, affecting the product quality inside.', 'We apologize for the inconvenience and will ensure better packaging in the future.'),
(18, 'Normal Feedback', 'Sithma Bandara', 'sithma.bandara@example.com', 'Very satisfied with the overall quality and service.', 'Thank you for your kind feedback! We’re delighted you’re satisfied with our products and services.'),
(19, 'Complaint', 'Charitha Maduranga', 'charitha.maduranga@example.com', 'The product was not as described on the website.', 'We apologize for the confusion. Please contact us for a replacement or return.'),
(20, 'Normal Feedback', 'Anjana Perera', 'anjana.perera@example.com', 'It would be great to have an online tracking system for orders.', 'Thank you for your suggestion. We will consider this feature for future developments.');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Contact` int(10) NOT NULL,
  `Password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`ID`, `Email`, `First_Name`, `Last_Name`, `Address`, `Contact`, `Password`) VALUES
(1, 'n@gmail.com', 'John', 'Doe', '123 Elm Street', 1234567890, '12345678'),
(2, 'jane.smith@example.com', 'Jane', 'Smith', '456 Oak Avenue', 2147483647, 'password23'),
(3, 'alice.johnson@example.com', 'Alice', 'Johnson', '789 Pine Road', 2147483647, 'password34'),
(4, 'bob.brown@example.com', 'Bob', 'Brown', '101 Maple Lane', 2147483647, 'password45'),
(5, 'mary.davis@example.com', 'Mary', 'Davis', '202 Birch Drive', 2147483647, 'password56'),
(6, 'michael.martin@example.com', 'Michael', 'Martin', '303 Cedar Boulevard', 2147483647, 'password67'),
(7, 'emily.wilson@example.com', 'Emily', 'Wilson', '404 Redwood Avenue', 2147483647, 'password78'),
(8, 'david.moore@example.com', 'David', 'Moore', '505 Spruce Circle', 2147483647, 'password89'),
(9, 'susan.taylor@example.com', 'Susan', 'Taylor', '606 Fir Street', 2147483647, 'password90'),
(10, 'william.jones@example.com', 'William', 'Jones', '707 Ash Way', 123456789, 'password01');

-- --------------------------------------------------------

--
-- Table structure for table `debit_table`
--

CREATE TABLE `debit_table` (
  `DebitID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `CardNumber` varchar(16) NOT NULL,
  `ExpiryDate` varchar(7) NOT NULL,
  `CVV` varchar(4) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` datetime NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `debit_table`
--

INSERT INTO `debit_table` (`DebitID`, `OrderID`, `CardNumber`, `ExpiryDate`, `CVV`, `Amount`, `PaymentDate`, `CreatedAt`) VALUES
(1, 1, '1234567899876', '2025-02', '453', 1250.00, '2025-02-27 00:00:00', '2025-02-27 13:34:03');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `driver_email` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `products` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Pending','Accepted','Rejected','Completed') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`delivery_id`, `driver_id`, `driver_email`, `destination`, `delivery_date`, `products`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 'n@gmail.com', 'Colombo', '2025-03-01', 'Polythene Bags, HDPE Sheets', '2025-02-28 18:30:00', '2025-02-28 18:30:00', ''),
(2, 2, 'jane.smith@example.com', 'Kandy', '2025-03-02', 'Shrink Film, Polythene Rolls', '2025-03-01 18:30:00', '2025-03-01 18:30:00', ''),
(3, 1, 'n@gmail.com', 'Galle', '2025-03-03', 'Garbage Bags, Bubble Wrap', '2025-03-02 18:30:00', '2025-03-02 18:30:00', 'Pending'),
(4, 4, 'kumar.gamage@example.com', 'Matara', '2025-03-04', 'Plastic Granules, Shrink Film', '2025-03-03 18:30:00', '2025-03-03 18:30:00', ''),
(5, 5, 'tharindu.jayasinghe@example.com', 'Negombo', '2025-03-05', 'HDPE Sheets, Polythene Bags', '2025-03-04 18:30:00', '2025-03-04 18:30:00', 'Pending'),
(6, 6, 'samantha.silva@example.com', 'Anuradhapura', '2025-03-06', 'Polythene Rolls, Garbage Bags', '2025-03-05 18:30:00', '2025-03-05 18:30:00', ''),
(7, 7, 'pradeep.weerasinghe@example.com', 'Jaffna', '2025-03-07', 'Plastic Granules, Shrink Film', '2025-03-06 18:30:00', '2025-03-06 18:30:00', 'Pending'),
(8, 1, 'n@gmail.com', 'Kurunegala', '2025-03-08', 'Polythene Bags, Bubble Wrap', '2025-03-07 18:30:00', '2025-03-07 18:30:00', ''),
(9, 9, 'niroshan.fernando@example.com', 'Vavuniya', '2025-03-09', 'HDPE Sheets, Polythene Rolls', '2025-03-08 18:30:00', '2025-03-08 18:30:00', 'Pending'),
(10, 10, 'ashan.wickramasinghe@example.com', 'Colombo', '2025-03-10', 'Shrink Film, Plastic Granules', '2025-03-09 18:30:00', '2025-03-09 18:30:00', ''),
(11, 1, 'n@gmail.com', 'Kandy', '2025-03-11', 'Garbage Bags, Polythene Bags', '2025-03-10 18:30:00', '2025-03-10 18:30:00', ''),
(12, 2, 'jane.smith@example.com', 'Matara', '2025-03-12', 'Bubble Wrap, HDPE Sheets', '2025-03-11 18:30:00', '2025-03-11 18:30:00', 'Pending'),
(13, 1, 'n@gmail.com', 'Jaffna', '2025-03-13', 'Plastic Granules, Polythene Rolls', '2025-03-12 18:30:00', '2025-03-12 18:30:00', ''),
(14, 4, 'kumar.gamage@example.com', 'Kurunegala', '2025-03-14', 'Polythene Bags, Garbage Bags', '2025-03-13 18:30:00', '2025-03-13 18:30:00', 'Pending'),
(15, 5, 'tharindu.jayasinghe@example.com', 'Vavuniya', '2025-03-15', 'Shrink Film, Bubble Wrap', '2025-03-14 18:30:00', '2025-03-14 18:30:00', ''),
(16, 6, 'samantha.silva@example.com', 'Colombo', '2025-03-16', 'Polythene Rolls, HDPE Sheets', '2025-03-15 18:30:00', '2025-03-15 18:30:00', 'Pending'),
(17, 7, 'pradeep.weerasinghe@example.com', 'Galle', '2025-03-17', 'Garbage Bags, Polythene Bags', '2025-03-16 18:30:00', '2025-03-16 18:30:00', ''),
(18, 8, 'chandima.dissanayake@example.com', 'Negombo', '2025-03-18', 'Bubble Wrap, Plastic Granules', '2025-03-17 18:30:00', '2025-03-17 18:30:00', 'Pending'),
(19, 9, 'niroshan.fernando@example.com', 'Kandy', '2025-03-19', 'Shrink Film, HDPE Sheets', '2025-03-18 18:30:00', '2025-03-18 18:30:00', ''),
(20, 10, 'ashan.wickramasinghe@example.com', 'Anuradhapura', '2025-03-20', 'Polythene Bags, Polythene Rolls', '2025-03-19 18:30:00', '2025-03-19 18:30:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE `distributor` (
  `driver_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `role` varchar(50) NOT NULL,
  `vehicle_no` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` (`driver_id`, `name`, `nic`, `role`, `vehicle_no`, `created_at`, `updated_at`, `status`, `reason`, `user_email`) VALUES
(1, 'John Doe', '881234567V', 'Driver', 'XYZ-1234', '2025-02-28 18:30:00', '2025-02-28 18:30:00', 'Active', 'No issues', 'john.doe@example.com'),
(2, 'Jane Smith', '890876543V', 'Driver', 'XYZ-5678', '2025-03-01 18:30:00', '2025-03-01 18:30:00', 'Active', 'No issues', 'jane.smith@example.com'),
(3, 'Raj Perera', '800123456V', 'Driver', 'XYZ-9101', '2025-03-02 18:30:00', '2025-03-02 18:30:00', 'Inactive', 'Vehicle maintenance', 'raj.perera@example.com'),
(4, 'Kumar Gamage', '911234567V', 'Driver', 'XYZ-1122', '2025-03-03 18:30:00', '2025-03-03 18:30:00', 'Active', 'No issues', 'kumar.gamage@example.com'),
(5, 'Tharindu Jayasinghe', '820987654V', 'Driver', 'XYZ-3344', '2025-03-04 18:30:00', '2025-03-04 18:30:00', 'Active', 'No issues', 'tharindu.jayasinghe@example.com'),
(6, 'Samantha Silva', '930456789V', 'Driver', 'XYZ-5566', '2025-03-05 18:30:00', '2025-03-05 18:30:00', 'Inactive', 'Medical leave', 'samantha.silva@example.com'),
(7, 'Pradeep Weerasinghe', '840123456V', 'Driver', 'XYZ-7788', '2025-03-06 18:30:00', '2025-03-06 18:30:00', 'Active', 'No issues', 'pradeep.weerasinghe@example.com'),
(8, 'Olivia Miller', '213546879V', 'distributor', '19-3564', '2025-03-07 18:30:00', '2025-03-04 18:25:23', 'Available', NULL, 'distributor@example.com'),
(10, 'Ashan Wickramasinghe', '870987123V', 'Driver', 'XYZ-4455', '2025-03-09 18:30:00', '2025-03-09 18:30:00', 'Active', 'No issues', 'ashan.wickramasinghe@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `eperformance`
--

CREATE TABLE `eperformance` (
  `eno` int(11) NOT NULL,
  `jrole` varchar(255) NOT NULL,
  `skill` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eperformance`
--

INSERT INTO `eperformance` (`eno`, `jrole`, `skill`) VALUES
(1, 'Production Manager', 'Team Management, Process Optimization'),
(2, 'Employee', 'Material Testing, Quality Assurance'),
(3, 'Warehouse Supervisor', 'Inventory Management, Logistics Coordination'),
(4, 'Machine Operator', 'Machine Setup, Polythene Production'),
(5, 'Maintenance Technician', 'Machine Maintenance, Troubleshooting'),
(6, 'Sales Manager', 'Customer Relationship, Sales Strategy'),
(7, 'Procurement Officer', 'Supplier Negotiations, Inventory Control'),
(8, 'Packaging Specialist', 'Packaging Design, Product Handling'),
(9, 'Supply Chain Coordinator', 'Order Fulfillment, Supplier Communication'),
(10, 'HR Manager', 'Employee Training, Performance Management');

-- --------------------------------------------------------

--
-- Table structure for table `genorder`
--

CREATE TABLE `genorder` (
  `oid` int(11) NOT NULL,
  `suid` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `odate` date NOT NULL,
  `rdate` date NOT NULL,
  `pmatirial` varchar(20) NOT NULL,
  `quantity` int(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genorder`
--

INSERT INTO `genorder` (`oid`, `suid`, `email`, `odate`, `rdate`, `pmatirial`, `quantity`, `status`) VALUES
(1, 1, 'n@gmail.com', '2025-03-01', '2025-03-05', 'Low-Density Polyethy', 500, 'Pending'),
(2, 2, 'supplier2@example.com', '2025-03-02', '2025-03-06', 'High-Density Polyeth', 400, 'Transferred'),
(3, 1, 'n@gmail.com', '2025-03-03', '2025-03-07', 'Polypropylene (PP)', 600, 'Confirmed'),
(4, 4, 'supplier4@example.com', '2025-03-04', '2025-03-08', 'Polyvinyl Chloride (', 350, 'Pending'),
(5, 1, 'n@gmail.com', '2025-03-05', '2025-03-09', 'Color Pigments', 200, 'Transferred'),
(6, 6, 'supplier6@example.com', '2025-03-06', '2025-03-10', 'Plasticizers', 150, 'Confirmed'),
(7, 1, 'n@gmail.com', '2025-03-07', '2025-03-11', 'UV Stabilizers', 180, 'Pending'),
(8, 8, 'supplier8@example.com', '2025-03-08', '2025-03-12', 'Recycled Polyethylen', 300, 'Transferred'),
(9, 9, 'supplier9@example.com', '2025-03-09', '2025-03-13', 'Polyethylene Terepht', 450, 'Confirmed'),
(10, 10, 'supplier10@example.com', '2025-03-10', '2025-03-14', 'Anti-Static Additive', 220, 'Pending'),
(11, 2, 'supplier2@example.com', '2025-03-01', '2025-03-05', 'Colorant', 500, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `inquire`
--

CREATE TABLE `inquire` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Messege` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquire`
--

INSERT INTO `inquire` (`ID`, `Name`, `Email`, `Subject`, `Messege`) VALUES
(1, 'Rajitha Perera', 'rajitha.perera@example.com', 'Bulk Order Inquiry', 'I am interested in ordering a large quantity of polythene bags. Please provide the pricing details and available sizes.'),
(2, 'Shirantha Wijesinghe', 'shirantha.wijesinghe@example.com', 'Product Quality Inquiry', 'Can you provide more information about the thickness and quality control of your polythene products?'),
(3, 'Nalini Kumari', 'nalini.kumari@example.com', 'Delivery Time Inquiry', 'How long does it take for bulk orders to be delivered? I need them urgently.'),
(4, 'Gihan Perera', 'gihan.perera@example.com', 'Custom Orders', 'Do you offer custom-sized polythene bags? I need bags with specific dimensions.'),
(5, 'Vishal Fernando', 'vishal.fernando@example.com', 'Payment Terms', 'What are the payment terms for wholesale orders? Is there any discount for large volumes?'),
(6, 'Dinesh Gunawardena', 'dinesh.gunawardena@example.com', 'Eco-friendly Products', 'Do you have any eco-friendly alternatives for your polythene bags?'),
(7, 'Sithma Rajapaksha', 'sithma.rajapaksha@example.com', 'Product Inquiry', 'I am interested in your shrink film. Can you share more about its properties and applications?'),
(8, 'Samanthika Jayasinghe', 'samanthika.jayasinghe@example.com', 'Return Policy', 'I received a defective batch of bags. What is your return or exchange policy?'),
(9, 'Tharindu Perera', 'tharindu.perera@example.com', 'Bulk Purchase Discount', 'Do you offer any discounts for large quantity purchases? I am looking to place a bulk order for our business.'),
(10, 'Chamika Bandara', 'chamika.bandara@example.com', 'Quality Control Standards', 'Could you please explain your quality control standards and how you ensure the quality of your products?');

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `ID` int(11) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `Note` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Solution` text NOT NULL DEFAULT 'Pending',
  `UserEmail` varchar(255) NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`ID`, `Type`, `Note`, `Description`, `Solution`, `UserEmail`, `Created_At`) VALUES
(1, 'Customer Complaint', 'Defective Product', 'Customer reported receiving torn polythene bags.', 'Replaced the damaged products.', 'customer1@example.com', '2025-02-28 18:30:00'),
(2, 'Supplier Delay', 'Late Raw Material Delivery', 'Supplier delayed HDPE raw material delivery.', 'Negotiated a faster shipping arrangement.', 'supplier1@example.com', '2025-03-01 18:30:00'),
(3, 'Customer Inquiry', 'Bulk Order Request', 'Customer inquired about bulk discount for polythene sheets.', 'Provided a customized price quote.', 'customer2@example.com', '2025-03-02 18:30:00'),
(4, 'Supplier Quality Issue', 'Low-Quality Material', 'Supplier delivered substandard plastic granules.', 'Requested replacement or refund.', 'supplier2@example.com', '2025-03-03 18:30:00'),
(5, 'Customer Complaint', 'Late Delivery', 'Customer’s order was not delivered on the promised date.', 'Issued a discount and expedited shipping.', 'customer3@example.com', '2025-03-04 18:30:00'),
(6, 'Supplier Payment Issue', 'Invoice Discrepancy', 'Mismatch in the invoiced and delivered quantities.', 'Resolved the issue with supplier reconciliation.', 'supplier3@example.com', '2025-03-05 18:30:00'),
(7, 'Customer Feedback', 'Product Packaging Concern', 'Customer suggested using eco-friendly packaging.', 'Evaluating biodegradable alternatives.', 'customer4@example.com', '2025-03-06 18:30:00'),
(8, 'Supplier Contract Issue', 'Price Increase Dispute', 'Supplier increased material prices unexpectedly.', 'Negotiated a long-term price lock.', 'supplier4@example.com', '2025-03-07 18:30:00'),
(9, 'Customer Return', 'Wrong Product Delivered', 'Customer received the wrong size of shrink film.', 'Arranged return and replacement.', 'customer5@example.com', '2025-03-08 18:30:00'),
(10, 'Supplier Compliance', 'Regulatory Requirement', 'Supplier did not provide required certification.', 'Requested compliance documents before next order.', 'supplier5@example.com', '2025-03-09 18:30:00'),
(11, 'Customer Unavailable', 'Not at home', 'Customer wasn\'t at home', 'Pending', 'distributor@example.com', '2025-03-04 18:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `leaveID` int(11) NOT NULL,
  `userID` varchar(25) NOT NULL,
  `leaveDate` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`leaveID`, `userID`, `leaveDate`, `reason`, `status`) VALUES
(1, '1', '2025-03-01', 'Medical leave due to illness', 'Approved'),
(2, '2', '2025-03-03', 'Family emergency', 'Approved'),
(3, '3', '2025-03-04', 'Personal reasons', 'Pending'),
(4, '1', '2025-03-06', 'Vacation', 'Approved'),
(5, '2', '2025-03-07', 'Health check-up', 'Approved'),
(6, '6', '2025-03-09', 'Attending a wedding', 'Pending'),
(7, '7', '2025-03-10', 'Sick leave', 'Approved'),
(8, '3', '2025-03-12', 'Traveling for work-related meeting', 'Approved'),
(9, '10', '2025-03-15', 'Personal time off', 'Pending'),
(10, '11', '2025-03-17', 'Religious observance', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `ownertask`
--

CREATE TABLE `ownertask` (
  `id` int(11) NOT NULL,
  `task` varchar(255) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ownertask`
--

INSERT INTO `ownertask` (`id`, `task`, `time`, `date`, `description`, `created_at`) VALUES
(1, 'Conducting a meeting with managers', '10:30:00', '2025-03-05', 'Discussing future progress plans', '2025-03-04 16:25:25');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentDate` datetime NOT NULL,
  `PaymentType` varchar(50) NOT NULL,
  `PaymentDetails` text DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`PaymentID`, `OrderID`, `PaymentDate`, `PaymentType`, `PaymentDetails`, `Amount`, `CreatedAt`) VALUES
(1, 1, '2025-02-27 00:00:00', 'Debit', 'Payment processed via Debit', 1250.00, '2025-02-27 13:34:03');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_table`
--

CREATE TABLE `paypal_table` (
  `PaypalID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `VerificationCode` varchar(100) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` datetime NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pmstock`
--

CREATE TABLE `pmstock` (
  `sid` int(11) NOT NULL,
  `pmid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `sdate` date NOT NULL,
  `rsdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pmstock`
--

INSERT INTO `pmstock` (`sid`, `pmid`, `quantity`, `location`, `status`, `sdate`, `rsdate`) VALUES
(1, 1, 8000, 'Raw Material Warehouse A', 'Available', '2025-03-01', '2025-03-10'),
(2, 2, 6000, 'Raw Material Warehouse B', 'Available', '2025-03-02', '2025-03-12'),
(3, 3, 5000, 'Raw Material Warehouse A', 'Low Stock', '2025-03-03', '2025-03-15'),
(4, 4, 7500, 'Raw Material Warehouse C', 'Available', '2025-03-04', '2025-03-18'),
(5, 5, 3000, 'Raw Material Warehouse B', 'Low Stock', '2025-03-05', '2025-03-20'),
(6, 6, 9000, 'Raw Material Warehouse C', 'Available', '2025-03-06', '2025-03-22'),
(7, 7, 4000, 'Raw Material Warehouse A', 'Low Stock', '2025-03-07', '2025-03-25'),
(8, 8, 7000, 'Raw Material Warehouse D', 'Available', '2025-03-08', '2025-03-28'),
(9, 9, 10000, 'Raw Material Warehouse B', 'Available', '2025-03-09', '2025-03-30'),
(10, 10, 3500, 'Raw Material Warehouse D', 'Low Stock', '2025-03-10', '2025-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `name`, `description`, `price`, `quantity`) VALUES
(1, 'LDPE Bags', 'Low-Density Polyethylene bags for packaging', 0.5, 5000),
(2, 'HDPE Sheets', 'High-Density Polyethylene sheets for industrial use', 2, 2000),
(3, 'Plastic Wrap', 'Transparent stretch film for food packaging', 1.2, 3000),
(4, 'Garbage Bags', 'Heavy-duty black garbage bags', 0.75, 4000),
(5, 'Shrink Film', 'Polyethylene shrink wrap for product packaging', 1.8, 2500),
(6, 'Polythene Rolls', 'General-purpose polythene rolls for various applications', 3.5, 1500),
(7, 'Bubble Wrap', 'Protective plastic bubble wrap for fragile items', 2.5, 1800),
(8, 'PP Woven Bags', 'Durable polypropylene woven bags for storage', 2.2, 2200),
(9, 'Plastic Granules', 'Raw polyethylene granules for manufacturing', 5, 5000),
(10, 'UV Resistant Sheets', 'Polythene sheets with UV protection for outdoor use', 4, 1200),
(12, 'Colorants', 'Color Powders for the color of bags', 50, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `pstock`
--

CREATE TABLE `pstock` (
  `sid` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `sdate` date DEFAULT NULL,
  `rsdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pstock`
--

INSERT INTO `pstock` (`sid`, `pid`, `quantity`, `location`, `status`, `sdate`, `rsdate`) VALUES
(1, 1, 5000, 'Warehouse A', 'Available', '2025-03-01', '2025-03-10'),
(2, 2, 2000, 'Warehouse B', 'Low Stock', '2025-03-02', '2025-03-12'),
(3, 3, 3000, 'Warehouse A', 'Available', '2025-03-03', '2025-03-15'),
(4, 4, 4000, 'Warehouse C', 'Available', '2025-03-04', '2025-03-18'),
(5, 5, 2500, 'Warehouse B', 'Low Stock', '2025-03-05', '2025-03-20'),
(6, 6, 1500, 'Warehouse C', 'Available', '2025-03-06', '2025-03-22'),
(7, 7, 1800, 'Warehouse A', 'Low Stock', '2025-03-07', '2025-03-25'),
(8, 8, 2200, 'Warehouse D', 'Available', '2025-03-08', '2025-03-28'),
(9, 9, 5000, 'Warehouse B', 'Available', '2025-03-09', '2025-03-30'),
(10, 10, 1200, 'Warehouse D', 'Low Stock', '2025-03-10', '2025-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleID` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleID`, `description`) VALUES
(1, 'Inspection of production line for quality control.'),
(2, 'Review of polythene bag manufacturing process for improvements.'),
(3, 'Planning maintenance for machines and equipment.'),
(4, 'Staff meeting to discuss daily production targets.'),
(5, 'Training session on new machinery for production workers.'),
(6, 'Monitoring the material supply chain and managing inventory.'),
(7, 'Audit of packaging and shipping processes to ensure quality.'),
(8, 'Scheduling of product packaging and labeling for delivery.'),
(9, 'Weekly review of worker performance and productivity.'),
(10, 'Reviewing customer complaints and feedback for product improvements.'),
(12, 'Add employee performance reports'),
(13, '');

-- --------------------------------------------------------

--
-- Table structure for table `sgenpay`
--

CREATE TABLE `sgenpay` (
  `ID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `OrderID` varchar(255) NOT NULL,
  `OrderDate` date NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `OrderAmount` decimal(10,2) NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sgenpay`
--

INSERT INTO `sgenpay` (`ID`, `SupplierID`, `Email`, `OrderID`, `OrderDate`, `Quantity`, `Price`, `OrderAmount`, `Status`) VALUES
(1, 1, 'n@gmail.com', '3', '2025-03-03', 600, 2.50, 1500.00, 'Paid'),
(2, 6, 'supplier6@example.com', '6', '2025-03-06', 150, 5.00, 750.00, 'Paid'),
(3, 9, 'supplier9@example.com', '9', '2025-03-09', 450, 3.20, 1440.00, 'Paid'),
(4, 1, 'n@gmail.com', '02', '2025-03-05', 10, 4.00, 140.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `additionalNotes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `email`, `password`, `role`, `name`, `nic`, `gender`, `phone`, `additionalNotes`) VALUES
(1, 'owner@example.com', 'owner123', 'owner', 'John Doe', '123456789V', 'Male', '0771234567', 'Owner of the company'),
(2, 'fmanager@example.com', 'fmanager123', 'fmanager', 'Jane Smith', '987654321V', 'Female', '0772345678', 'Factory manager overseeing production'),
(3, 'pmanager@example.com', 'pmanager123', 'pmanager', 'Michael Johnson', '192837465V', 'Male', '0773456789', 'Production manager for factory operations'),
(4, 'imanager@example.com', 'imanager123', 'imanager', 'Sarah Williams', '564738291V', 'Female', '0774567890', 'Inventory manager for product stock management'),
(5, 'supervisor@example.com', 'supervisor123', 'supervisor', 'David Brown', '746382910V', 'Male', '0775678901', 'Supervisor in the production department'),
(6, 'employee@example.com', 'employee123', 'employee', 'Emily Clark', '837291564V', 'Female', '0776789012', 'General worker in the factory'),
(7, 'skeeper@example.com', 'skeeper123', 'skeeper', 'Daniel Evans', '918273645V', 'Male', '0777890123', 'Stock keeper managing inventory records'),
(8, 'distributor@example.com', 'distributor123', 'distributor', 'Olivia Miller', '213546879V', 'Female', '0778901234', 'Distributor handling product shipments'),
(9, 'tmanager@example.com', 'tmanager123', 'tmanager', 'Sarah Williams', '564738292V', 'Male', '0774567890', 'Transport manager for trnsport management');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stockID` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `item` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stockID`, `name`, `quantity`, `status`, `item`) VALUES
('1', 'LDPE Bags', 5000, 'Available', 'Finished Product'),
('10', 'UV Resistant Sheets', 1200, 'Low Stock', 'Finished Product'),
('2', 'HDPE Sheets', 2000, 'Low Stock', 'Finished Product'),
('3', 'Plastic Wrap', 3000, 'Available', 'Finished Product'),
('4', 'Garbage Bags', 4000, 'Available', 'Finished Product'),
('5', 'Shrink Film', 2500, 'Low Stock', 'Finished Product'),
('6', 'Polythene Rolls', 1500, 'Available', 'Finished Product'),
('7', 'Bubble Wrap', 1800, 'Low Stock', 'Finished Product'),
('8', 'PP Woven Bags', 2200, 'Available', 'Finished Product'),
('9', 'Plastic Granules', 5000, 'Available', 'Raw Material');

-- --------------------------------------------------------

--
-- Table structure for table `suppayment`
--

CREATE TABLE `suppayment` (
  `PaymentID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `Amount` int(20) NOT NULL,
  `Method` varchar(10) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppayment`
--

INSERT INTO `suppayment` (`PaymentID`, `SupplierID`, `Email`, `OrderID`, `PaymentDate`, `Currency`, `Amount`, `Method`, `Status`) VALUES
(1, 1, 'n@gmail.com', 5001, '2025-02-25', 'USD', 1500, 'Bank Trans', 'Accepted'),
(2, 1, 'n@gmail.com', 5002, '2025-02-26', 'LKR', 250000, 'Cheque', 'Pending'),
(3, 1, 'n@gmail.com', 5003, '2025-02-27', 'EUR', 2001, 'Credit Car', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `ID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `First_Name` varchar(255) NOT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Contact` varchar(10) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`ID`, `Email`, `First_Name`, `Last_Name`, `Address`, `Contact`, `Password`) VALUES
(1, 'n@gmail.com', 'John', 'Doe', '123 Supplier St', '1234567890', '12345678'),
(2, 'supplier2@example.com', 'Jane', 'Smith', '456 Supplier Ave', '2345678901', 'supplier234'),
(3, 'supplier3@example.com', 'Alice', 'Johnson', '789 Supplier Rd', '3456789012', 'supplier345'),
(4, 'supplier4@example.com', 'Bob', 'Brown', '101 Supplier Ln', '4567890123', 'supplier456'),
(5, 'supplier5@example.com', 'Mary', 'Davis', '202 Supplier Dr', '5678901234', 'supplier567'),
(6, 'supplier6@example.com', 'Michael', 'Martin', '303 Supplier Blvd', '6789012345', 'supplier678'),
(7, 'supplier7@example.com', 'Emily', 'Wilson', '404 Supplier Ave', '7890123456', 'supplier789'),
(8, 'supplier8@example.com', 'David', 'Moore', '505 Supplier Cir', '8901234567', 'supplier890'),
(9, 'supplier9@example.com', 'Susan', 'Taylor', '606 Supplier St', '9012345678', 'supplier901'),
(10, 'supplier10@example.com', 'William', 'Jones', '707 Supplier Way', '0123456789', 'supplier012');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `taskname` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `assignto` varchar(100) NOT NULL,
  `assignby` varchar(100) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `sstatus` enum('Pending','Accepted','Rejected','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `taskname`, `description`, `assignto`, `assignby`, `startdate`, `enddate`, `sstatus`, `created_at`) VALUES
(1, 'update inventory', 'check and update stock levels', 'supervisor@example.com', 'Factory Manager', '2025-03-04', '2025-03-11', 'Pending', '2025-03-04 04:35:11'),
(2, 'client meeting', 'discuss annual workflow ', 'supervisor@example.com', 'Factory Manager', '2025-03-05', '2025-03-05', 'Accepted', '2025-03-04 04:39:08'),
(3, 'Employee Training', 'conduct training for new employees', 'supervisor@example.com', 'Factory Manager', '2025-03-06', '2025-03-13', 'Pending', '2025-03-04 04:38:00'),
(4, 'Conduting employee meeting', 'Conduct a meeting with the employees for performance analysis', 'fmanager@example.com', 'Owner', '2025-03-04', '2025-03-11', 'Accepted', '2025-03-04 16:49:24'),
(5, 'Transport ', 'From Colombo to Mathara', 'pmanager@example.com', 'Transport Manager ', '2025-03-05', '2025-03-06', 'Pending', '2025-03-05 04:29:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addorder`
--
ALTER TABLE `addorder`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `credit_table`
--
ALTER TABLE `credit_table`
  ADD PRIMARY KEY (`CreditID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `cusfeedback`
--
ALTER TABLE `cusfeedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `debit_table`
--
ALTER TABLE `debit_table`
  ADD PRIMARY KEY (`DebitID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `driver_email` (`driver_email`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`driver_id`),
  ADD KEY `nic` (`nic`),
  ADD KEY `vehicle_no` (`vehicle_no`);

--
-- Indexes for table `eperformance`
--
ALTER TABLE `eperformance`
  ADD PRIMARY KEY (`eno`);

--
-- Indexes for table `genorder`
--
ALTER TABLE `genorder`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `suid` (`suid`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `inquire`
--
ALTER TABLE `inquire`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`leaveID`);

--
-- Indexes for table `ownertask`
--
ALTER TABLE `ownertask`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `paypal_table`
--
ALTER TABLE `paypal_table`
  ADD PRIMARY KEY (`PaypalID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `pmstock`
--
ALTER TABLE `pmstock`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `pstock`
--
ALTER TABLE `pstock`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleID`);

--
-- Indexes for table `sgenpay`
--
ALTER TABLE `sgenpay`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SupplierID` (`SupplierID`),
  ADD KEY `Email` (`Email`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stockID`);

--
-- Indexes for table `suppayment`
--
ALTER TABLE `suppayment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `SupplierID` (`SupplierID`),
  ADD KEY `Email` (`Email`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addorder`
--
ALTER TABLE `addorder`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `credit_table`
--
ALTER TABLE `credit_table`
  MODIFY `CreditID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cusfeedback`
--
ALTER TABLE `cusfeedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `debit_table`
--
ALTER TABLE `debit_table`
  MODIFY `DebitID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `distributor`
--
ALTER TABLE `distributor`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `genorder`
--
ALTER TABLE `genorder`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inquire`
--
ALTER TABLE `inquire`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `leaveID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ownertask`
--
ALTER TABLE `ownertask`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paypal_table`
--
ALTER TABLE `paypal_table`
  MODIFY `PaypalID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pmstock`
--
ALTER TABLE `pmstock`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sgenpay`
--
ALTER TABLE `sgenpay`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `suppayment`
--
ALTER TABLE `suppayment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addorder`
--
ALTER TABLE `addorder`
  ADD CONSTRAINT `addorder_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`productID`);

--
-- Constraints for table `credit_table`
--
ALTER TABLE `credit_table`
  ADD CONSTRAINT `credit_table_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `addorder` (`OrderID`) ON DELETE CASCADE;

--
-- Constraints for table `debit_table`
--
ALTER TABLE `debit_table`
  ADD CONSTRAINT `debit_table_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `addorder` (`OrderID`) ON DELETE CASCADE;

--
-- Constraints for table `genorder`
--
ALTER TABLE `genorder`
  ADD CONSTRAINT `genorder_ibfk_1` FOREIGN KEY (`suid`) REFERENCES `supplier` (`ID`),
  ADD CONSTRAINT `genorder_ibfk_2` FOREIGN KEY (`email`) REFERENCES `supplier` (`Email`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `addorder` (`OrderID`) ON DELETE CASCADE;

--
-- Constraints for table `paypal_table`
--
ALTER TABLE `paypal_table`
  ADD CONSTRAINT `paypal_table_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `addorder` (`OrderID`) ON DELETE CASCADE;

--
-- Constraints for table `pstock`
--
ALTER TABLE `pstock`
  ADD CONSTRAINT `pstock_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `sgenpay`
--
ALTER TABLE `sgenpay`
  ADD CONSTRAINT `sgenpay_ibfk_1` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`ID`),
  ADD CONSTRAINT `sgenpay_ibfk_2` FOREIGN KEY (`Email`) REFERENCES `supplier` (`Email`);

--
-- Constraints for table `suppayment`
--
ALTER TABLE `suppayment`
  ADD CONSTRAINT `suppayment_ibfk_1` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`ID`),
  ADD CONSTRAINT `suppayment_ibfk_2` FOREIGN KEY (`Email`) REFERENCES `supplier` (`Email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
